<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
	document.documentElement.classList.add('dark')
	tailwind.config = {
 			 darkMode: 'class',
		theme: {
			extend: {
			colors: {
				primary: {"50":"#ecfeff","100":"#cffafe","200":"#a5f3fc","300":"#67e8f9","400":"#22d3ee","500":"#06b6d4","600":"#0891b2","700":"#0e7490","800":"#155e75","900":"#164e63"}
			}
		},
		fontFamily: {
			'body': [
			'Inter', 
			'ui-sans-serif', 
			'system-ui', 
			'-apple-system', 
			'system-ui', 
			'Segoe UI', 
			'Roboto', 
			'Helvetica Neue', 
			'Arial', 
			'Noto Sans', 
			'sans-serif', 
			'Apple Color Emoji', 
			'Segoe UI Emoji', 
			'Segoe UI Symbol', 
			'Noto Color Emoji'
			],
			'sans': [
			'Inter', 
			'ui-sans-serif', 
			'system-ui', 
			'-apple-system', 
			'system-ui', 
			'Segoe UI', 
			'Roboto', 
			'Helvetica Neue', 
			'Arial', 
			'Noto Sans', 
			'sans-serif', 
			'Apple Color Emoji', 
			'Segoe UI Emoji', 
			'Segoe UI Symbol', 
			'Noto Color Emoji'
			]
		}
		}
	}
  </script>
</head>
<body class="dark:bg-gray-900">
	<section class="bg-gray-50 dark:bg-gray-900">
		<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
			<h1 class="text-[40px] mt-2 font-bold leading-tight tracking-[0.7rem] text-center text-gray-900 md:text-2xl lg:text-2xl dark:text-white">
                VMOND
            </h1>
            <span class="text-[40px] font-light leading-tight tracking-[0.7rem] text-center text-gray-900 dark:text-white">
                CAFE
            </span>
			
			<div class="w-full bg-white rounded-lg shadow dark:border mt-4 md:mt-2 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
				<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
					<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
						Sign in to your account
					</h1>
					<form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
						@csrf
						<div>
							<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
							<input type="email" name="email" id="email" class="focus-input100 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@company.com" required="">
							@error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="focus-input100" data-placeholder="Email"></span>
						</div>
						<div>
							<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
							<input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							<span class="focus-input100" data-placeholder="Password"></span>
						</div>
						<button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
						<p class="text-sm font-light text-gray-500 dark:text-gray-400">
							Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	  </section>
</body>
</html>