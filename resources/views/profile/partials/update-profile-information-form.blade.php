<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Photo -->
        <div>
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            
            @if ($user->profile_photo_path)
                <div class="mt-2 mb-4">
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                </div>
            @endif

            <input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Biography')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Social Links -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Social Media Links') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="facebook" :value="__('Facebook URL')" />
                    <x-text-input id="facebook" name="facebook" type="url" class="mt-1 block w-full" :value="old('facebook', $user->facebook)" placeholder="https://facebook.com/username" />
                    <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
                </div>

                <div>
                    <x-input-label for="twitter" :value="__('X (Twitter) URL')" />
                    <x-text-input id="twitter" name="twitter" type="url" class="mt-1 block w-full" :value="old('twitter', $user->twitter)" placeholder="https://x.com/username" />
                    <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
                </div>

                <div>
                    <x-input-label for="instagram" :value="__('Instagram URL')" />
                    <x-text-input id="instagram" name="instagram" type="url" class="mt-1 block w-full" :value="old('instagram', $user->instagram)" placeholder="https://instagram.com/username" />
                    <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
                </div>

                <div>
                    <x-input-label for="linkedin" :value="__('LinkedIn URL')" />
                    <x-text-input id="linkedin" name="linkedin" type="url" class="mt-1 block w-full" :value="old('linkedin', $user->linkedin)" placeholder="https://linkedin.com/in/username" />
                    <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
