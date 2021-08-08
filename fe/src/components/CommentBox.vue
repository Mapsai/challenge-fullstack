<template>
  <div v-if="comment" class="container-sm bg-light">
    <div class="row p-3">
      <div class="col-1">
        <img src="@/assets/default-user-icon-13.png">
      </div>

      <div class="col-11">
        <h5 class="mt-0">{{ comment.user }} <span class="text-shrunk text-muted">{{ comment.date }}</span></h5>
        {{ comment.body }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    comment: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
img {
  max-width: 48px;
  max-height: 48px;
}

.text-shrunk {
  font-size: 0.8rem;
}
</style>
