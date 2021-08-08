<template>
  <div class="container-sm p-4">
    <validation-observer ref="observer" v-slot="{ handleSubmit }">
      <b-form @submit.stop.prevent="submit()">
        <validation-provider name="Comment" :rules="{ required: true }" v-slot="validationContext">
          <b-form-group>
            <b-form-input
              required
              v-model="comment"
              :state="getValidationState(validationContext)"
              placeholder="Add a comment"
            ></b-form-input>

            <b-form-invalid-feedback>{{ validationContext.errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </validation-provider>

        <div class="mt-2">
          <button type="submit" class="btn btn-success m-1">Post</button>
          <button type="button" @click="comment = ''" class="btn btn-secondary m-1">Cancel</button>
        </div>
      </b-form>
    </validation-observer>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    token: {},
  },
  data() {
    return {
      comment: '',
      alertMessage: '',
      dismissCountDown: 0,
    };
  },
  methods: {
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },
    submit() {
      axios.post(process.env.VUE_APP_BACKEND_URL + '/comment', { comment: this.comment, authToken: this.token } ).then(response => {
        this.$emit(response.data.success ? 'submitSuccess' : 'submitFail');
      });
    },
  },
};
</script>
