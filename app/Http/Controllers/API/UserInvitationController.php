<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInvitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * @OA\Info(
 * title="Swagger with Laravel",
 * version="1.0.0",
 * )
 */

class UserInvitationController extends Controller
{
    //function accept invitations
    /**
     * @OA\Post(
     *     path="/api/accept-invitation",
     *     summary="Accept an invitation",
     *     tags={"User Invitations"},
     *    @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string", example="user@example.com"),
     *          description="The email address associated with the invitation"
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitation accepted and user created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invitation accepted and user created!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invitation does not exist or Role 'user' does not exist",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invitation does not exist")
     *         )
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Invitation expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invitation expired")
     *         )
     *     )
     * )
     */
    public function acceptInvite(Request $request)
    {
        $email = $request->input('email');

        // Find the invitation by email
        $invitation = UserInvitation::where('email', $email)->first();

        if (!$invitation) {
            return response()->json([
                'error' => 'Invitation does not exist'
            ], 404);
        }

        $time = Carbon::now();
        $expiryTime = $invitation->invitation_expiry;

        // Check if the invitation has expired
        if ($time->greaterThan($expiryTime)) {
            return response()->json([
                'error' => 'Invitation expired'
            ], 419);
        }

        // Create a new user
        $user = new User();
        $user->name = $invitation->name;
        $user->email = $invitation->email;
        $user->password = Hash::make($invitation->password); // Set a default password or handle password assignment securely

        // Save the user
        $user->save();

        $invitation->status='Accepted';
        $invitation->save();

        // Find the "user" role and attach it to the newly created user
        $role = Role::where('name', 'user')->first();

        if ($role) {
            $user->roles()->attach($role->id);
        } else {
            return response()->json([
                'error' => 'Role "user" does not exist'
            ], 404);
        }

        return response()->json([
            'message' => 'Invitation accepted and user created!'
        ], 200);
    }

//    resend Invitation
    /**
     * @OA\Post(
     *     path="/api/resend-invitation",
     *     summary="Resend an invitation",
     *     tags={"User Invitations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitation Resent",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invitation Resend")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Invitation Already Accepted",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invitation Already Accepted")
     *         )
     *     )
     * )
     */
    public function resendInvitation(Request $request){
        $email=$request->input('email');

        $nowDate=Carbon::now();

        $invitation=UserInvitation::where('email', $email)->first();
        if($invitation->status ==='Accepted'){
            return response()->json(['error'=>'Invitation Already Accepted'], 409);
        }

        $expiryDate=$invitation->invitation_expiry;

        if($nowDate>$expiryDate){
            $invitation->invitation_expiry= Carbon::now()->addHour(24);

            $invitation->save();

            return response()->json([
                'message'=> 'Invitation Resend'
            ]);
        }
    }

}
