<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unauthorized Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full px-6 py-12 bg-white shadow-xl rounded-2xl text-center border border-gray-100">
        <div class="w-20 h-20 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Authorization Error</h1>
        <p class="text-gray-500 mb-8">You do not have permission to access this area or perform this action. Please
            login with an administrator account.</p>
        <div class="flex flex-col gap-3">
            <a href="http://localhost:8001"
                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 transition-colors w-full shadow-sm">
                Return to KLE Blog Home
            </a>

            <form action="{{ route('filament.admin.auth.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-200 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors w-full shadow-sm">
                    Login with a Different Account (Logout)
                </button>
            </form>
        </div>
    </div>
</body>

</html>