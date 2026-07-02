
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ __('Name') }}</label>
                        <input id="name" type="text" class="w-full px-4 py-2.5 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#19140035] dark:border-[#3E3E3A] rounded-md text-[#1b1b18] dark:text-[#EDEDEC] text-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent transition-all @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="w-full px-4 py-2.5 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#19140035] dark:border-[#3E3E3A] rounded-md text-[#1b1b18] dark:text-[#EDEDEC] text-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent transition-all @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1.5" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password" class="w-full px-4 py-2.5 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#19140035] dark:border-[#3E3E3A] rounded-md text-[#1b1b18] dark:text-[#EDEDEC] text-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent transition-all @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1.5" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="w-full px-4 py-2.5 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#19140035] dark:border-[#3E3E3A] rounded-md text-[#1b1b18] dark:text-[#EDEDEC] text-sm focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:border-transparent transition-all" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="w-full py-3 mt-4 bg-[#1b1b18] hover:bg-black dark:bg-[#eeeeec] dark:hover:bg-white text-white dark:text-[#1C1C1A] text-sm font-semibold rounded-md shadow-md transition-all duration-200 active:scale-[0.98] cursor-pointer">
                        {{ __('Get Started') }}
                    </button>
                </form>