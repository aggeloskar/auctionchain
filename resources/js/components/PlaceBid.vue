<template>
  <div>
    <form method="POST" action="placebid">
      VUE FORM
      <div class="form-group">
        <label for="exampleInputPassword1">New Bid</label>
        <input type="text" v-model="bid" class="form-control" name="bid" />
        {{bid}}
        <input type="hidden" :value="itemid" name="id" />
        <input type="hidden" name="_token" :value="csrf" />
      </div>
      <button type="submit" class="btn btn-primary btn-block">Place bid</button>
      END VUE FORM
    </form>
    <button v-on:click="test">TEST</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      bid: null,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  props: ["itemid"],
  methods: {
    test: function() {
      console.log(web3.version);
      console.log(web3.eth.accounts);
    }
  },
  mounted() {
    console.log(this.bid);
  }
};
</script>