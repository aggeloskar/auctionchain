<template>
  <div>
    <form method="POST" action="placebid" id="placebid">
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
    test: async function() {
      console.log(web3.version);
      var contract = new web3.eth.Contract(
        [
          {
            constant: false,
            inputs: [],
            name: "finalizeAuction",
            outputs: [],
            payable: false,
            stateMutability: "nonpayable",
            type: "function"
          },
          {
            constant: false,
            inputs: [{ name: "_bid", type: "uint256" }],
            name: "placeBid",
            outputs: [{ name: "", type: "bool" }],
            payable: true,
            stateMutability: "payable",
            type: "function"
          },
          {
            inputs: [
              { name: "_owner", type: "address" },
              { name: "_title", type: "string" },
              { name: "_startPrice", type: "uint256" },
              { name: "_description", type: "string" }
            ],
            payable: false,
            stateMutability: "nonpayable",
            type: "constructor"
          },
          {
            constant: true,
            inputs: [],
            name: "auctionState",
            outputs: [{ name: "", type: "uint8" }],
            payable: false,
            stateMutability: "view",
            type: "function"
          },
          {
            constant: true,
            inputs: [{ name: "", type: "address" }],
            name: "bids",
            outputs: [{ name: "", type: "uint256" }],
            payable: false,
            stateMutability: "view",
            type: "function"
          },
          {
            constant: true,
            inputs: [],
            name: "highestBidder",
            outputs: [{ name: "", type: "address" }],
            payable: false,
            stateMutability: "view",
            type: "function"
          },
          {
            constant: true,
            inputs: [],
            name: "highestPrice",
            outputs: [{ name: "", type: "uint256" }],
            payable: false,
            stateMutability: "view",
            type: "function"
          },
          {
            constant: true,
            inputs: [],
            name: "returnContents",
            outputs: [
              { name: "", type: "string" },
              { name: "", type: "uint256" },
              { name: "", type: "string" },
              { name: "", type: "uint8" }
            ],
            payable: false,
            stateMutability: "view",
            type: "function"
          }
        ],
        "0x6fa8e0463be33d879a9ac270113fa40f88c90273"
      );
      console.log(contract);
      var content = await contract.methods.returnContents().call();
      console.log(content);
      var highestPrice = await contract.methods.highestPrice().call();
      console.log(highestPrice);
      //document.getElementById("placebid").submit();
    }
  },
  mounted() {
    console.log(this.itemid);
  }
};
</script>