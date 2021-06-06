<x-guest-layout>
  <x-auth-card>
    {{-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

    {{-- <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!--First Name -->
      <div class="mt-4">
        <x-label for="first_name" :value="__('First Name')" />

        <x-input id="first_name" required class="block mt-1 w-full" type="text" name="first_name"
          :value="old('first_name')" autofocus />
        @error('first_name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Last Name -->
      <div class="mt-4">
        <x-label for="last_name" :value="__('Last Name')" />

        <x-input id="last_name" required class="block mt-1 w-full" type="text" name="last_name"
          :value="old('last_name')" />
        @error('last_name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Phone -->
      <div class="mt-4">
        <x-label for="phone" :value="__('Phone')" />

        <x-input id="phone" required class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" />
        @error('phone')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-label for="email" :value="__('Email')" />

        <x-input id="email" required class="block mt-1 w-full" type="email" name="email" :value="old('email')" />

        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password" :value="__('Password')" />

        <x-input id="password" required class="block mt-1 w-full" type="password" name="password"
          autocomplete="new-password" />

        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-input id="password_confirmation" required class="block mt-1 w-full" type="password"
          name="password_confirmation" />

        @error('password_confirmation')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <!-- Operating Policy -->
      <div class="block mt-4">
        <label for="operating_policy" class="inline-flex items-center">
          <input id="operating_policy" type="checkbox"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            name="operating_policy">
          <span class="ml-2 text-sm text-gray-600">Yes, i accept the <b><a
                href="{{route('operating_policy')}}">Operating Policy</a></b></span>
        </label>
        @error('operating_policy')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>
        <x-button class="ml-4">
          {{ __('Register') }}
        </x-button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>