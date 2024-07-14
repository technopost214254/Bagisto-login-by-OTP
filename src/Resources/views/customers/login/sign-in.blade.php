<!-- SEO Meta Content -->
@push('meta')
    <meta 
        name="description" 
        content="@lang('otp-login::app.customers.login-form.page-title')"
    />

    <meta 
        name="keywords" 
        content="@lang('otp-login::app.customers.login-form.page-title')"
    />
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('otp-login::app.customers.login-form.page-title')
    </x-slot>

    <v-customer-login />

    @pushOnce('scripts')
    {!! Captcha::renderJS() !!}
        <script
            type="text/x-template"
            id="v-customer-login-template"
            >
            <div class="max-1180:px-5 container mt-20 max-md:mt-12">
                {!! view_render_event('bagisto.shop.customers.login.logo.before') !!}

                <!-- Company Logo -->
                <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="m-[0_auto_20px_auto]"
                        aria-label="@lang('otp-login::app.customers.login-form.bagisto')"
                    >
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ config('app.name') }}"
                            width="131"
                            height="29"
                        >
                    </a>
                </div>

                {!! view_render_event('bagisto.shop.customers.login.logo.after') !!}

                 <!-- Form Container -->
                <div class="m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-16 px-[90px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
                    <h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                        @lang('otp-login::app.customers.login-form.page-title')
                    </h1>

                    <p class="mt-4 text-xl text-zinc-500 max-sm:mt-0 max-sm:text-sm">
                        @lang('otp-login::app.customers.login-form.form-login-text')
                    </p>

                    {!! view_render_event('bagisto.shop.customers.login.before') !!}

                    <div class="mt-14 rounded max-sm:mt-8">
                        <!-- :action="route('shop.customer.session.create')" -->
                        <x-shop::form
                            v-slot="{ meta, errors, handleSubmit }"
                            as="div"
                        >
                            <form
                                @submit.prevent="handleSubmit($event, submitOtp)"
                                enctype="multipart/form-data"
                                ref="submitOtp"
                                >
                                {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

                                <!-- Email -->
                                <x-shop::form.control-group>
                                    <x-shop::form.control-group.label class="required">
                                        @lang('otp-login::app.customers.login-form.email')
                                    </x-shop::form.control-group.label>

                                    <x-shop::form.control-group.control
                                        type="email"
                                        class="px-6 py-4 max-md:py-3 max-sm:py-2"
                                        name="email"
                                        rules="required|email"
                                        value=""
                                        :label="trans('otp-login::app.customers.login-form.email')"
                                        placeholder="email@example.com"
                                        :aria-label="trans('otp-login::app.customers.login-form.email')"
                                        aria-required="true"
                                    />

                                    <x-shop::form.control-group.error control-name="email" />
                                </x-shop::form.control-group>

                                <!-- OTP -->
                                <x-shop::form.control-group v-if="requestForOtp">
                                    <x-shop::form.control-group.label class="required">
                                        @lang('otp-login::app.customers.login-form.otp')
                                    </x-shop::form.control-group.label>

                                    <x-shop::form.control-group.control
                                        type="password"
                                        class="px-6 py-4 max-md:py-3 max-sm:py-2"
                                        id="otp"
                                        name="otp"
                                        rules="required|min:6"
                                        value=""
                                        :label="trans('otp-login::app.customers.login-form.otp')"
                                        :placeholder="trans('otp-login::app.customers.login-form.otp')"
                                        :aria-label="trans('otp-login::app.customers.login-form.otp')"
                                        aria-required="true"
                                    />

                                    <x-shop::form.control-group.error control-name="otp" />
                                </x-shop::form.control-group>

                                <div class="flex justify-between" v-if="requestForOtp">
                                    <div class="flex select-none items-center gap-1.5">
                                        <input
                                            type="checkbox"
                                            id="show-password"
                                            class="peer hidden"
                                            @change="switchVisibility()"
                                        />

                                        <label
                                            class="icon-uncheck peer-checked:icon-check-box text-navyBlue peer-checked:text-navyBlue cursor-pointer text-2xl max-sm:text-xl"
                                            for="show-password"
                                        ></label>

                                        <label
                                            class="cursor-pointer select-none text-base text-zinc-500 ltr:pl-0 rtl:pr-0 max-sm:text-sm"
                                            for="show-password"
                                        >
                                            @lang('otp-login::app.customers.login-form.show-otp')
                                        </label>
                                    </div>

                                    <div class="block"></div>
                                </div>

                                <!-- Captcha -->
                                @if (core()->getConfigData('customer.captcha.credentials.status'))
                                    <div class="mt-5 flex">
                                        {!! Captcha::render() !!}
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="mt-8 flex flex-wrap items-center gap-9 max-sm:justify-center max-sm:gap-5 max-sm:text-center">
                                    <x-shop::button
                                        v-if="requestForOtp"
                                        class="primary-button m-0 mx-auto flex w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base ltr:ml-0 rtl:mr-0 max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5"
                                        :title="trans('otp-login::app.customers.login-form.button-title')"
                                        ::disabled="isLoading"
                                        ::loading="isLoading"
                                        @click="customerLogin"
                                    />

                                    <x-shop::button
                                        v-else
                                        class="primary-button m-0 mx-auto flex w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base ltr:ml-0 rtl:mr-0 max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5"
                                        :title="trans('otp-login::app.customers.login-form.otp-title')"
                                        ::disabled="isLoading"
                                        ::loading="isLoading"
                                    />

                                    {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                                </div>

                                <!-- Re Send OTP -->
                                <button
                                    v-if="requestForOtp"
                                    type="button"
                                    class="text-navyBlue"
                                    @click="submitOtp"
                                    >
                                    @lang('otp-login::app.customers.login-form.re-send-otp')
                                </button>
                            </form>
                        </x-shop::form>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.login.after') !!}

                    <p class="mt-5 font-medium text-zinc-500 max-sm:text-center max-sm:text-sm">
                        @lang('otp-login::app.customers.login-form.new-customer')

                        <a
                            class="text-navyBlue"
                            href="{{ route('shop.customers.register.index') }}"
                        >
                            @lang('otp-login::app.customers.login-form.create-your-account')
                        </a>
                    </p>
                </div>

                <p class="mb-4 mt-8 text-center text-xs text-zinc-500">
                    @lang('otp-login::app.customers.login-form.footer')
                </p>
            </div>
        </script>
        
        <script type="module">
            app.component('v-customer-login', {
                template: '#v-customer-login-template',

                data() {
                    return {
                        requestForOtp: false,
                        isLoading: false,
                        form: {
                            form: '',
                            otp: null,
                        },
                    }
                },

                methods: {
                    submitOtp() {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.submitOtp);

                        this.$axios.post("{{ route('shop.customer.session.create') }}", formData)
                            .then((response) => {
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.requestForOtp = true;
                                this.isLoading = false;

                                return;
                            })
                            .catch(error => {
                                this.requestForOtp = false;
                                this.isLoading = false;

                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },

                    customerLogin () {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.submitOtp);

                        this.$axios.post("{{ route('shop.customer.session.verify-otp') }}", formData)
                            .then((response) => {
                                this.isLoading = false;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                window.location.href = response.data.redirect;
                            })
                            .catch(error => {
                                this.isLoading = false;

                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },
                    
                    switchVisibility() {
                        let passwordField = document.getElementById("otp");

                        passwordField.type = passwordField.type === "password"
                            ? "text"
                            : "password";
                    },
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
