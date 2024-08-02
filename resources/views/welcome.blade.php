<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/01f5f71df4.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-gray-white dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">



                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-50 flex flex-col gap-4">
                            <div class="bg-white dark:bg-gray-300  shadow-2xl overflow-hidden  sm:rounded-lg p-6 text-gray-900 dark:text-gray-700 ">
                                @if(auth()->check())
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <button type="submit">Logout</button>
                                    </form>

                                @else
                                <form class="flex flex-row gap-4" method="POST" action="/login">
                                    @csrf

                                    <div class="flex flex-col">
                                        <label for="email">email</label>
                                        <input type="text" id="email" name="email" required autofocus>
                                    </div>

                                    <div class="flex flex-col">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" required>
                                    </div class="flex flex-col" >

                                    <div>
                                        <button type="submit">Login</button>
                                    </div>
                                    <p>email: test@test.pl password: test , if you are using db:seed</p>
                                </form>
                                @endif
                            </div>
                            <div class="bg-white dark:bg-gray-300  shadow-2xl overflow-hidden  sm:rounded-lg ">

                                <div class="p-6 text-gray-900 dark:text-gray-700 flex flex-row" x-data="{ visibleGroup: 'pet' }">
                                    <div class="flex flex-col w-1/3 gap-3">
                                        <button @click="visibleGroup = 'pet'" class=" justify-between  duration-300 items-center hover:bg-gray-600 flex w-full pr-5 bg-gray-50 text-gray-600 rounded-full p-3 hover:text-gray-100" >
                                            <p>Pets</p><i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                        <button @click="visibleGroup = 'store'" class=" justify-between  duration-300 items-center hover:bg-gray-600 flex w-full pr-5 bg-gray-50 text-gray-600 rounded-full p-3 hover:text-gray-100" >
                                            <p>Store</p><i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                        <button @click="visibleGroup = 'user'" class=" justify-between  duration-300 items-center hover:bg-gray-600 flex w-full pr-5 bg-gray-50 text-gray-600 rounded-full p-3 hover:text-gray-100" >
                                            <p>Users</p><i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    </div>
                                    <div class="flex flex-col pl-6 border-l border-black ml-4">
                                        <div x-show="visibleGroup === 'pet'">
                                            <h1 class="text-xl">Pets</h1>

                                            <hr class="border-black my-3">
                                            <form action="pet/uploadImage" method="post" enctype="multipart/form-data">
                                                @csrf

                                                <div>
                                                    <label for="petId">Pet ID</label>
                                                    <input type="number" id="petId" name="petId" required>
                                                </div>
                                                <div>
                                                    <label for="file">File</label>
                                                    <input type="file" id="file" name="file" required multiple>
                                                </div>

                                                <button type="submit">Upload</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form method="POST" action="/pet" enctype="multipart/form-data">
                                                @csrf


                                                <div>
                                                    <label for="category_id">Category ID</label>
                                                    <input type="number" id="category_id" name="category_id" required>
                                                </div>

                                                <div>
                                                    <label for="name">Name</label>
                                                    <input type="text" id="name" name="name" required>
                                                </div>

                                                <div>
                                                    <div>
                                                        <label for="files">File</label>
                                                        <input type="file" id="file" name="files[]" required multiple>
                                                    </div>
                                                </div>

                                                <div>

                                                    <label for="tags_id">Tag IDs</label>
                                                    <div id="tags_id" name="tags[][id]" multiple required>
                                                        <label for="tag_1">Tag 1</label>
                                                        <input type="checkbox" id="tag_1" name="tags[][id]" value="1">
                                                        <label for="tag_2">Tag 2</label>
                                                        <input type="checkbox" id="tag_2" name="tags[][id]" value="2">
                                                        <label for="tag_3">Tag 3</label>
                                                        <input type="checkbox" id="tag_3" name="tags[][id]" value="3">

                                                    </div>
                                                </div>


                                                <div>
                                                    <label for="status">Status</label>
                                                    <select id="status" name="status" required>
                                                        <option value="available">Available</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="sold">Sold</option>
                                                    </select>
                                                </div>

                                                <button type="submit">Add Pet</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form id="updateForm" method="POST" action="/pet/update">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label for="petId">Pet ID</label>
                                                    <input type="number" id="petId" name="petId" required >
                                                </div>
                                                <div>
                                                    <label for="category_id">Category ID</label>
                                                    <input type="number" id="category_id" name="category_id" >
                                                </div>

                                                <div>
                                                    <label for="name">Name</label>
                                                    <input type="text" id="name" name="name" >
                                                </div>

                                                <div>
                                                    <label for="tags_id">Tag IDs</label>
                                                    <div id="tags_id" name="tags[][id]" multiple >
                                                        <label for="tag_1">Tag 1</label>
                                                        <input type="checkbox" id="tag_1" name="tags[][id]" value="1">
                                                        <label for="tag_2">Tag 2</label>
                                                        <input type="checkbox" id="tag_2" name="tags[][id]" value="2">
                                                        <label for="tag_3">Tag 3</label>
                                                        <input type="checkbox" id="tag_3" name="tags[][id]" value="3">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="status">Status</label>
                                                    <select id="status" name="status" >
                                                        <option value="available">Available</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="sold">Sold</option>
                                                    </select>
                                                </div>

                                                <button type="submit">Update Pet</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form method="GET" action="/pet/findByStatus">
                                                @csrf
                                                <div>
                                                    <label for="status_available">Available</label>
                                                    <input type="checkbox" id="status_available" name="status[]" value="available">
                                                </div>

                                                <div>
                                                    <label for="status_pending">Pending</label>
                                                    <input type="checkbox" id="status_pending" name="status[]" value="pending">
                                                </div>

                                                <div>
                                                    <label for="status_sold">Sold</label>
                                                    <input type="checkbox" id="status_sold" name="status[]" value="sold">
                                                </div>

                                                <button type="submit">Find Pets By Status</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form id="findPetForm" method="GET" action="/pet/get">
                                                @method('GET')
                                                @csrf
                                                <div>
                                                    <label for="id">Pet ID</label>
                                                    <input type="number" id="id" name="id" required >
                                                </div>
                                                <button type="submit">Find Pet By ID</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form id="updatePetForm" method="POST" action="/pet/update">
                                                @csrf
                                                <div>
                                                    <label for="petId">Pet ID</label>
                                                    <input type="number" id="petId" name="petId" required >
                                                </div>
                                                <div>
                                                    <label for="name">Name</label>
                                                    <input type="text" id="name" name="name">
                                                </div>
                                                <div>
                                                    <label for="status">Status</label>
                                                    <select id="status" name="status">
                                                        <option value="available">Available</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="sold">Sold</option>
                                                    </select>
                                                </div>
                                                <button type="submit">Update Pet</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form id="deletePetForm" method="POST" action="/pet/delete">
                                                @csrf
                                                @method('DELETE')
                                                <div>
                                                    <label for="petId">Pet ID</label>
                                                    <input type="number" id="petId" name="petId" required>
                                                </div>
                                                <input type="hidden" id="apikey" name="apikey" value="test">
                                                <button type="submit">Delete Pet</button>
                                            </form>


                                        </div>
                                        <div x-show="visibleGroup === 'store'">
                                            <h1 class="text-xl">Store</h1>

                                            <hr class="border-black my-3">
                                            <form action="store/inventory" method="GET">
                                                @csrf
                                                <button type="submit" >Get inventory</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form method="POST" id="orderForm" action="/store/order">
                                                @csrf
                                                <label for="petId">Pet ID:</label><br>
                                                <input type="number" id="petId" name="petId" required><br>
                                                <label for="quantity">Quantity:</label><br>
                                                <input type="number" id="quantity" name="quantity" required><br>
                                                <label for="shipDate">Ship Date:</label><br>
                                                <input type="date" id="shipDate" name="shipDate" required><br>

                                                <button type="submit">Place Order</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form method="GET" id="orderForm" action="/store/order/find_purchase">
                                                @csrf
                                                <label for="orderId">Order ID</label><br>
                                                <input type="number" id="orderId" name="orderId" required><br>
                                                <button type="submit">Place Order</button>
                                            </form>

                                            <hr class="border-black my-3">
                                            <form method="POST" action="/store/order/delete">
                                                @csrf
                                                @method('DELETE')
                                                <label for="orderId">Order ID</label><br>
                                                <input type="number" id="orderId" name="orderId" required><br>
                                                <button type="submit">Delete Order</button>
                                            </form>


                                        </div>
                                        <div x-show="visibleGroup === 'user'">
                                            <h1>Users</h1>

                                            <hr class="border-black my-3">
                                            <form action="user/get" >
                                                <label for="username">Username:</label><br>
                                                <input type="text" id="username" name="username"><br>
                                                <button type="submit" >Get User</button>
                                            </form>



                                            <hr class="border-black my-3">
                                            <?php $users = [
    [
        "username" => "user1",
        "firstName" => "First",
        "lastName" => "User",
        "email" => "user1@example.com",
        "password" => "password1",
        "phone" => "1234567890",
    ],
    [
        "username" => "user2",
        "firstName" => "Second",
        "lastName" => "User",
        "email" => "user2@example.com",
        "password" => "password2",
        "phone" => "0987654321",
    ],
    [
        "username" => "user3",
        "firstName" => "Third",
        "lastName" => "User",
        "email" => "user3@example.com",
        "password" => "password3",
        "phone" => "1029384756",
    ]
];?>
                                            <form action="/user/create_with_list" method="POST">
                                                @csrf
                                                <input type="hidden" name="users" value="{{ serialize($users) }}">
                                                <button type="submit" >Create Users</button>
                                            </form>


                                            @if(auth()->check())
                                            <hr class="border-black my-3">
                                            <form action="/user/create" method="POST">
                                                @csrf
                                                <div>
                                                    <label for="username">Username:</label><br>
                                                    <input type="text" id="username" name="username" required><br>
                                                </div>
                                                <div>
                                                    <label for="firstName">First Name:</label><br>
                                                    <input type="text" id="firstName" name="firstName" required><br>
                                                </div>
                                                <div>
                                                    <label for="lastName">Last Name:</label><br>
                                                    <input type="text" id="lastName" name="lastName" required><br>
                                                </div>
                                                <div>
                                                    <label for="email">Email:</label><br>
                                                    <input type="email" id="email" name="email" required><br>
                                                </div>
                                                <div>
                                                    <label for="password">Password:</label><br>
                                                    <input type="password" id="password" name="password" required><br>
                                                </div>
                                                <div>
                                                    <label for="phone">Phone:</label><br>
                                                    <input type="text" id="phone" name="phone" required><br>
                                                </div>
                                                <button type="submit">Create User</button>
                                            </form>
                                            <hr class="border-black my-3">
                                            <form action="/user/update" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <label for="username">Username:</label><br>
                                                <input type="text" id="username" name="username" required><br>
                                                <label for="firstName">First Name:</label><br>
                                                <input type="text" id="firstName" name="firstName"><br>
                                                <label for="lastName">Last Name:</label><br>
                                                <input type="text" id="lastName" name="lastName"><br>
                                                <label for="email">Email:</label><br>
                                                <input type="email" id="email" name="email"><br>
                                                <label for="password">Password:</label><br>
                                                <input type="password" id="password" name="password"><br>
                                                <label for="phone">Phone:</label><br>
                                                <input type="text" id="phone" name="phone"><br>
                                                <input type="submit" value="Update User">
                                            </form>

                                            <hr class="border-black my-3">
                                            <form action="/user/delete" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <label for="username">Username:</label><br>
                                                <input type="text" id="username" name="username" required><br>
                                                <button type="submit" >Delete User</button>
                                            </form>
                                            @else
                                                <hr class="border-black my-3">
                                                <p>You need to be logged in to create, update or delete users</p>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </body>
</html>
