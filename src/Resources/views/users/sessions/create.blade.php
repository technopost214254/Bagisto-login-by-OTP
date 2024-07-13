<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('opt-login::app.users.sessions.title')
    </x-slot>

    @pushOnce('styles')
        <style lang="less">
            .otp-input {
                width: 40px;
                height: 40px;
                padding: 5px;
                margin: 0 10px;
                font-size: 20px;
                border-radius: 4px;
                border: 1px solid rgba(0, 0, 0, 0.3);
                text-align: center;
                &.error {
                border: 1px solid red !important;
                }
            }
            .otp-input::-webkit-inner-spin-button,
            .otp-input::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
    @endPushOnce
    
    <v-login />

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-login-template"
            >
            <div class="flex h-[100vh] items-center justify-center">
                <div class="flex flex-col items-center gap-5">
                    <!-- Logo -->            
                    @if ($logo = core()->getConfigData('general.design.admin_logo.logo_image'))
                        <img
                            class="h-10 w-[110px]"
                            src="{{ Storage::url($logo) }}"
                            alt="{{ config('app.name') }}"
                        />
                    @else
                        <img
                            class="w-max" 
                            src="{{ bagisto_asset('images/logo.svg') }}"
                            alt="{{ config('app.name') }}"
                        />
                    @endif

                    <div class="box-shadow flex min-w-[300px] flex-col rounded-md bg-white dark:bg-gray-900">
                        <!-- Login Form -->
                        <x-admin::form
                            v-slot="{ meta, errors, handleSubmit }"
                            as="div"
                            ref="modelForm"
                        >
                            <form
                                @submit.prevent="handleSubmit($event, submitOtp)"
                                enctype="multipart/form-data"
                                ref="submitOtp"
                                >
                                <p class="p-4 text-xl font-bold text-gray-800 dark:text-white">
                                    @lang('opt-login::app.users.sessions.title')
                                </p>

                                <div class="border-y p-4 dark:border-gray-800">
                                    <!-- Email -->
                                    <x-admin::form.control-group>
                                        <x-admin::form.control-group.label class="required">
                                            @lang('opt-login::app.users.sessions.email')
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control 
                                            type="email" 
                                            class="w-[254px] max-w-full" 
                                            id="email"
                                            name="email" 
                                            rules="required|email"
                                            v-model="form.email"
                                            value="admin@example.com"
                                            :label="trans('opt-login::app.users.sessions.email')"
                                            :placeholder="trans('opt-login::app.users.sessions.email')"
                                        />
                                        
                                        <x-admin::form.control-group.error control-name="email" />
                                    </x-admin::form.control-group>

                                    <!-- OTP -->
                                    <x-admin::form.control-group 
                                        v-if="requestForOtp" 
                                        class="relative w-full"
                                        >
                                        <x-admin::form.control-group.label class="required">
                                            @lang('opt-login::app.users.sessions.otp')
                                        </x-admin::form.control-group.label>
                                
                                        <x-admin::form.control-group.control 
                                            type="password" 
                                            id="otp"
                                            name="otp" 
                                            v-model="form.otp"
                                            rules="required|min:6" 
                                            class="w-[254px] max-w-full ltr:pr-10 rtl:pl-10" 
                                            :label="trans('opt-login::app.users.sessions.otp')"
                                            :placeholder="trans('opt-login::app.users.sessions.otp')"
                                        />
                                
                                        <x-admin::form.control-group.error control-name="password" />
                                    </x-admin::form.control-group>
                                </div>

                                <div class="flex items-center justify-between p-4">
                                    <!-- Submit Button -->
                                    <x-admin::button
                                        v-if="requestForOtp"
                                        type="button"
                                        class="flex cursor-pointer justify-center rounded-md border border-blue-700 bg-blue-600 px-3.5 py-1.5 text-right font-semibold text-gray-50"
                                        :title="trans('opt-login::app.users.sessions.login')"
                                        ::loading="isLoading"
                                        ::disabled="isLoading"
                                        @click="customerLogin"
                                    >
                                        @lang('opt-login::app.users.sessions.login')
                                    </x-admin::button>

                                    <x-admin::button
                                        v-else
                                        class="flex cursor-pointer justify-center rounded-md border border-blue-700 bg-blue-600 px-3.5 py-1.5 text-right font-semibold text-gray-50"
                                        :title="trans('opt-login::app.users.sessions.send-otp')"
                                        ::loading="isLoading"
                                        ::disabled="isLoading"
                                    >
                                        @lang('opt-login::app.users.sessions.send-otp')
                                    </x-admin::button>

                                     <!-- Re Send OTP -->
                                     <button
                                        v-if="requestForOtp"
                                        type="button"
                                        class="cursor-pointer text-xs font-semibold leading-6 text-blue-600"
                                        @click="submitOtp"
                                    >
                                        @lang('opt-login::app.users.sessions.re-send-otp')
                                    </button>
                                </div>
                            </form>
                        </x-admin::form>
                    </div>
                </div>
            </div>
        </script>
        
        <script type="module">
            app.component('v-login', {
                template: '#v-login-template',

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

                        this.$axios.post("{{ route('admin.otp.session.store') }}", formData)
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

                        this.$axios.post("{{ route('admin.otp.session.verify-otp') }}", formData)
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
                },
            });
        </script>
    @endPushOnce

</x-admin::layouts.anonymous>
