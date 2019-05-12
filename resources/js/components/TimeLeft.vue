<template>
  <div>
    <div class="alert alert-info" role="alert">
      <strong>Current Bid:</strong>
      {{ findEndDate() }}
    </div>
    <div>Desc: {{ item.description }} {{item.id}}</div>
    <br>
    <form method="POST" action="placebid">
      <div class="form-group">
        <label for="exampleInputPassword1">New Bid</label>
        <input type="text" class="form-control" name="bid">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Place bid</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ["id", "startDate", "duration"],

  data() {
    return {
      item: []
    };
  },

  mounted() {
    console.log("moutned");

    axios.get("/api/test/" + this.id).then(response => {
      this.item = response.data;
    });
  },

  methods: {
    findEndDate() {
      return this.item.highest_bid;
    }
  }
};
</script>
