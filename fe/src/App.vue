<template>
  <div class="py-5">
    <div class="container-sm">
      <div class="row">
        <b-alert
          fade
          :variant="alert.type"
          :show="alert.countdown"
          @dismissed="alert.countdown = 0"
          @dismiss-count-down="countDownChanged"
        >
          {{ alert.message }}
        </b-alert>
      </div>
    </div>

    <div v-if="authToken">
      <template v-for="comment in comments">
        <comment-box :comment="comment"></comment-box>
      </template>
      <user-comment :token="authToken" @submitSuccess="submitSuccess" @submitFail="submitFail"></user-comment>
    </div>

    <div v-else>
      <login @failure="loginFail" @logged="loginSuccess"></login>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CommentBox from './components/CommentBox';
import Login from './components/Login';
import UserComment from './components/UserComment';

export default {
  data() {
    return {
      comments: [],
      authToken: null,
      alert: {
        message: '',
        type: '',
        countdown: 0,
      },
    };
  },
  methods: {
    loginFail($event) {
      this.alert = {
        countdown: 3,
        type: 'danger',
        message: $event,
      };
    },
    submitFail() {
      this.alert = {
        countdown: 3,
        type: 'danger',
        message: 'Failed to submit comment. Please try again later',
      };
    },
    loginSuccess($value) {
      this.authToken = $value;
      this.alert = {
        countdown: 3,
        type: 'success',
        message: 'Successfully logged in',
      };
      this.retrieveComments();
    },
    submitSuccess() {
      this.alert = {
        countdown: 3,
        type: 'success',
        message: 'Comment was successfully submitted',
      };
      this.retrieveComments();
    },
    retrieveComments() {
      this.comments = [];

      axios.post(process.env.VUE_APP_BACKEND_URL + '/comments', { authToken: this.authToken }).then(response => {
        if (!response.data.success) {
          this.alert = {
            countdown: 3,
            type: 'danger',
            message: 'Failed to retrieve comments. Please try again',
          };
        } else {
          this.comments = response.data.message.slice(0, 20); // Hardcoded for easier readability
        }
      });
    },
    countDownChanged(countdown) {
      this.alert.countdown = countdown;
    },
  },
  components: {
    CommentBox,
    Login,
    UserComment,
  },
};
</script>
