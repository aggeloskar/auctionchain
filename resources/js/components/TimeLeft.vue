<template>
  <div>
    <div class="alert alert-info" role="alert">
      <strong>Time Left:</strong>
      {{ findEndDate() }}
    </div>
  </div>
</template>

<script>
export default {
  props: ["startDate", "duration"],

  methods: {
    findEndDate() {
      return this.startDate + this.duration;
    }
  }
};
</script>
