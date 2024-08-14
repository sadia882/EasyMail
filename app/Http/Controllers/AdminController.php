<!-- <?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Validation\ValidationException;
// use Exception;

// class AdminController extends Controller
// {
//     public function store(Request $request)
//     {
//         try {
//             $validated = $request->validate([
//                 'name' => 'required|string|max:255',
//                 'email' => 'required|string|email|max:255|unique:users',
//                 'password' => 'required|string|min:8',
//             ]);

//             $user = User::create([
//                 'name' => $validated['name'],
//                 'email' => $validated['email'],
//                 'password' => Hash::make($validated['password']),
//             ]);

//             return response()->json($user, 201);
//         } catch (ValidationException $e) {
//             return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
//         } catch (Exception $e) {
//             return response()->json(['error' => 'An unexpected error occurred', 'message' => $e->getMessage()], 500);
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             $user = User::findOrFail($id);
//             $user->delete();

//             return response()->json(['message' => 'User deleted'], 200);
//         } catch (ModelNotFoundException $e) {
//             return response()->json(['error' => 'User not found'], 404);
//         } catch (Exception $e) {
//             return response()->json(['error' => 'An unexpected error occurred', 'message' => $e->getMessage()], 500);
//         }
//     }
// } -->
