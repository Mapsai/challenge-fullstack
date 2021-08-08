<template>
  <div class="container-sm">
    <div class="row">
      <b-card class="col-4 mt-3 m-auto p-0" header="Authentication">
        <validation-observer ref="observer" v-slot="{ handleSubmit }">
          <b-form @submit.stop.prevent="submit()">
            <validation-provider name="Email" :rules="{ required: true, email: true }" v-slot="validationContext">
              <b-form-group label="Email address:">
                <b-form-input
                  required
                  v-model="email"
                  :state="getValidationState(validationContext)"
                  type="email"
                  placeholder="Enter email"
                ></b-form-input>

                <b-form-invalid-feedback>{{ validationContext.errors[0] }}</b-form-invalid-feedback>
              </b-form-group>
            </validation-provider>

            <validation-provider name="Password" :rules="{ required: true }" v-slot="validationContext">
              <b-form-group label="Password:" class="mt-4">
                <b-form-input
                  required
                  type="password"
                  v-model="password"
                  :state="getValidationState(validationContext)"
                  placeholder="Enter password"
                ></b-form-input>

                <b-form-invalid-feedback>{{ validationContext.errors[0] }}</b-form-invalid-feedback>
              </b-form-group>
            </validation-provider>

            <b-button type="submit" variant="primary" class="mt-4">Login</b-button>
          </b-form>
        </validation-observer>
      </b-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },
    submit() {
      axios.post(process.env.VUE_APP_BACKEND_URL + '/login', { email: this.email, password: this.password }).then(response => {
        if (!response.data.success) {
          this.alertMessage = response.data.message;
          this.$emit('failure', response.data.message);
        } else {
          this.$emit('logged', response.data.message);
        }
      });
    },
  },
};
</script>
