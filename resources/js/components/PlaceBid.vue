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
    }
  },
  mounted: async function() {
    console.log("------------mounted--------------");
    /* console.log(this.contractaddress);
    var contractAddress = this.contractaddress;
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
          inputs: [],
          name: "placeBid",
          outputs: [
            {
              name: "",
              type: "bool"
            }
          ],
          payable: true,
          stateMutability: "payable",
          type: "function"
        },
        {
          inputs: [
            {
              name: "_owner",
              type: "address"
            },
            {
              name: "_title",
              type: "string"
            },
            {
              name: "_startPrice",
              type: "uint256"
            },
            {
              name: "_description",
              type: "string"
            }
          ],
          payable: false,
          stateMutability: "nonpayable",
          type: "constructor"
        },
        {
          constant: true,
          inputs: [],
          name: "auctionState",
          outputs: [
            {
              name: "",
              type: "uint8"
            }
          ],
          payable: false,
          stateMutability: "view",
          type: "function"
        },
        {
          constant: true,
          inputs: [
            {
              name: "",
              type: "address"
            }
          ],
          name: "bids",
          outputs: [
            {
              name: "",
              type: "uint256"
            }
          ],
          payable: false,
          stateMutability: "view",
          type: "function"
        },
        {
          constant: true,
          inputs: [],
          name: "highestBidder",
          outputs: [
            {
              name: "",
              type: "address"
            }
          ],
          payable: false,
          stateMutability: "view",
          type: "function"
        },
        {
          constant: true,
          inputs: [],
          name: "highestPrice",
          outputs: [
            {
              name: "",
              type: "uint256"
            }
          ],
          payable: false,
          stateMutability: "view",
          type: "function"
        },
        {
          constant: true,
          inputs: [],
          name: "returnContents",
          outputs: [
            {
              name: "",
              type: "string"
            },
            {
              name: "",
              type: "uint256"
            },
            {
              name: "",
              type: "string"
            },
            {
              name: "",
              type: "uint8"
            }
          ],
          payable: false,
          stateMutability: "view",
          type: "function"
        }
      ],
      contractAddress
    );
    console.log(contract);
    var content = await contract.methods.returnContents().call();
    console.log(content);
    var highestPrice = await contract.methods.highestPrice().call();
    console.log(highestPrice);
    console.log(this.highestbid); */
    /* Check if blockchain highest price is the same as database highestbid.
     ** If not, uses axios to update database values of highest bid and highest bidder.
     */
    /* if (highestPrice !== this.highestbid) {
      axios
        .post("/test", {
          name: "TEst name",
          description: "test descr"
        })
        .then(function(response) {
          console.log(response.data);
          //refresh page
        });
    }

    console.log("---------------end mounted----------------------"); */
  }
};
</script>