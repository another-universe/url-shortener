<template>
    <template v-if="result === null">
        <h1>Link shortener</h1>

        <form role="form" novalidate>
            <div class="mb-3">
                <label class="form-label" for="url">Enter URL to shorten</label>

                <input
                    v-model="form.url"
                    ref="url"
                    type="url"
                    :class="['form-control', {'is-invalid': error !== null}]"
                    name="url"
                    id="url"
                    required
                    @input="error !== null && (error = null)"
                />

                <div v-if="error !== null" class="invalid-feedback">
                    {{ error }}
                </div>
            </div>

            <div class="mb-3">
                <button
                    type="button"
                    class="btn btn-primary"
                    ref="submit"
                    :disabled="submitting"
                    @click="submit"
                >
                    {{ submitting ? 'Please wait...' : 'Submit' }}
                </button>
            </div>
        </form>

        <div
            v-if="alert !== null"
            class="alert alert-danger alert-dismissible"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <p ref="alertMessage">{{ alert }}</p>

            <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click="closeAlert"
            ></button>
        </div>
    </template>

    <template v-else>
        <h1>Result</h1>
        <div
            class="alert alert-success"
            aria-live="assertive"
            aria-atomic="true"
        >
            Shortened URL:
            <a
                :href="result"
                class="alert-link"
                target="_blank"
                ref="shortenedUrl"
                >{{ result }}</a
            >
        </div>

        <div class="d-grid">
            <button
                type="button"
                class="btn btn-primary btn-lg"
                @click="result = null"
            >
                shorten more
            </button>
        </div>
    </template>
</template>

<script>
export default {
    name: 'App',

    data() {
        return {
            form: {url: ''},
            error: null,
            result: null,
            alert: null,
            submitting: false,
        };
    },

    watch: {
        result: {
            handler(value) {
                if (value !== null) {
                    this.$refs.shortenedUrl.focus();
                } else {
                    this.$refs.url.focus();
                }
            },
            flush: 'post',
        },
    },

    methods: {
        async submit() {
            this.alert = null;

            if (this.error !== null) {
                return this.$refs.url.focus();
            }

            this.submitting = true;

            try {
                const response = await axios.post('/shorten-url', this.form),
                    {data} = response.data;
                this.form.url = '';
                this.result = data.url;
            } catch (e) {
                if (e.response && e.response.status === 422) {
                    this.error = e.response.data.errors.url[0];
                    await this.$nextTick();
                    return this.$refs.url.focus();
                }

                this.alert = 'Error occured. Try again.';
                await this.$nextTick();
                const ref = this.$refs.alertMessage,
                    tabIndex = ref.tabIndex;
                ref.tabIndex = 1;
                ref.focus();
                ref.tabIndex = tabIndex;
            } finally {
                this.submitting = false;
            }
        },

        async closeAlert() {
            this.alert = null;
            await this.$nextTick();
            this.$refs.submit.focus();
        },
    },

    mounted() {
        this.$refs.url.focus();
    },
};
</script>
