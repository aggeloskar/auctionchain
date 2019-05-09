<template>
  <div>
    <div class="alert alert-info" role="alert">
      <strong>Time Left:</strong>
      {{ findEndDate() }}
      {{ test }}
    </div>
  </div>
</template>

<script>
export default {
  props: ["startDate", "duration"],

  data() {
    return {
      test: null
    };
  },

  mounted() {
    axios
      .get("https://jsonplaceholder.typicode.com/todos/1")
      .then(response => (this.test = response.data.title));
  },

  methods: {
    findEndDate() {
      return this.startDate + this.duration;
    }
  }
};
</script>
