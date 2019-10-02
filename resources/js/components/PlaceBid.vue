<template>
  <div>
    <form v-on:submit.prevent="placebid" method="POST" action="placebid" id="placebid">
      <div class="form-group">
        <label for="exampleInputPassword1">New Bid</label>
        <input type="text" v-model="bid" class="form-control" name="bid" />
        <input type="hidden" :value="itemid" name="id" />
        <input type="hidden" name="_token" :value="csrf" />
      </div>

      <button class="btn btn-primary btn-block">Place bid</button>
    </form>
    <hr />
    <button v-on:click="endAuction()" class="btn btn-danger btn-block">End auction</button>
    <div class="loader"></div>
  </div>
</template>

<script>
import contractABI from "../contractABI";
export default {
  data() {
    return {
      bid: null,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  props: ["itemid", "highestbid", "contractaddress"],
  methods: {
    placebid: async function() {
      $("#placebid input").prop("readonly", true);
      if (!this.bid) {
        alert("Please enter a valid bid");
        $("#placebid input").prop("readonly", false);
      } else if (this.bid <= parseFloat(this.highestbid)) {
        alert("Enter a higher bid value");
        $("#placebid input").prop("readonly", false);
      } else {
        $("body").toggleClass("loading");
        var contractAddress = this.contractaddress;
        var contract = new web3.eth.Contract(contractABI, contractAddress);
        console.log(contract);
        var content = await contract.methods.returnContents().call();
        console.log(content);
        var highestPrice = await contract.methods.highestPrice().call();
        console.log(highestPrice);
        var bid = web3.utils.toWei(this.bid, "ether");
        console.log(bid);
        var account = (await web3.eth.getAccounts())[0];
        var bidsSoFar = await contract.methods.bids(account).call();
        bid = bid - bidsSoFar;

        /* if (highestPrice > parseFloat(bid)) {
          alert("NOPE");
          $("body").toggleClass("loading");

          return;
        } */

        contract.methods
          .placeBid()
          .send({
            from: account,
            value: bid
          })
          .on("transactionHash", function(hash) {
            console.log("transactionHash: " + hash);
          })
          .on("confirmation", function(confirmationNumber, receipt) {
            console.log("Transaction confirmed");
            document.getElementById("placebid").submit();
            $("body").toggleClass("loading");
          })
          .on("error", function(error) {
            console.log(error);
            $("#placebid input").prop("readonly", false);
            $("body").toggleClass("loading");
          });
      }
    },
    endAuction: async function() {
      var contractAddress = this.contractaddress;
      var contract = new web3.eth.Contract(contractABI, contractAddress);
      var account = (await web3.eth.getAccounts())[0];

      contract.methods
        .finalizeAuction()
        .send({
          from: account
        })
        .on("confirmation", function(confirmationNumber, receipt) {
          console.log(confirmationNumber);
          console.log(receipt);

          //axios.get("/end").then(alert("ENDED"));
          //This ^^ changes all active auctions to ended. TODO: change only this auction to ended.
        });
      axios
        .post("/end", {
          id: this.itemid,
          status: "ended"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(error => {
          console.log(error.message);
        })
        .then(alert("ended"));
    }
  },
  mounted: async function() {
    console.log("------------mounted--------------");
  }
};
</script>