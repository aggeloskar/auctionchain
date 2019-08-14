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

      <button type="submit" class="btn btn-primary btn-block" hidden>Place bid</button>
    </form>
    <hr />
    <div class="loader"></div>
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
  props: ["itemid", "highestbid"],
  methods: {
    placebid: async function() {
      $("#placebid input").prop("readonly", true);
      if (!this.bid) {
        alert("Please enter a valid bid");
        $("#placebid input").prop("readonly", false);
      } else if (this.bid <= parseInt(this.highestbid)) {
        alert("Enter a higher bid value");
        $("#placebid input").prop("readonly", false);
      } else {
        $("body").toggleClass("loading");

        var contractAddress = "0x7fc3d7b6c27647c7820da1e382ee351b9da93edc";
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
        var bid = web3.utils.toWei(this.bid, "ether");
        console.log(bid);

        /* if (highestPrice > parseFloat(bid)) {
          alert("NOPE");
          $("body").toggleClass("loading");

          return;
        } */
        var account = (await web3.eth.getAccounts())[0];
        contract.methods.placeBid().send(
          {
            from: account,
            value: bid
          },
          function(error, result) {
            if (!error && result) {
              alert(result);
              document.getElementById("placebid").submit();
            } else if (
              error.message.includes("User denied transaction signature")
            ) {
              alert("Error: User denied transaction signature");
              $("#placebid input").prop("readonly", false);
              $("body").toggleClass("loading");
            } else {
              alert("Unkown error");
              $("#placebid input").prop("readonly", false);
              $("body").toggleClass("loading");
            }
          }
        );
      }
    }
  },
  mounted: async function() {
    console.log("------------mounted--------------");

    var contractAddress = "0x7fc3d7b6c27647c7820da1e382ee351b9da93edc";
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
    console.log(this.highestbid);
    /* Check if blockchain highest price is the same as database highestbid.
     ** If not, uses axios to update database values of highest bid and highest bidder.
     */
    if (highestPrice !== this.highestbid) {
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

    console.log("---------------end mounted----------------------");
  }
};
</script>