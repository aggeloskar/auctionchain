<template>
  <div>
    <form v-on:submit.prevent="createAuction" method="POST" action="items" id="createauction">
      <div class="form-group row">
        <label for="title" class="col-md-4 col-form-label text-md-right">Item title</label>

        <div class="col-md-6">
          <input id="title" type="text" class="form-control" name="title" value required autofocus />
          <span class="invalid-feedback" role="alert">
            <strong></strong>
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="description" class="col-md-4 col-form-label text-md-right">Item Description</label>

        <div class="col-md-6">
          <input id="description" type="text" class="form-control" name="description" required />
          <span class="invalid-feedback" role="alert">
            <strong></strong>
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="itemPhoto" class="col-md-4 col-form-label text-md-right">Item Photo</label>

        <div class="col-md-6">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="itemPhoto" />
            <label class="custom-file-label" for="itemPhoto">Choose file</label>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label for="starting_price" class="col-md-4 col-form-label text-md-right">Starting Price</label>

        <div class="col-md-3">
          <input
            id="starting_price"
            type="text"
            class="form-control"
            name="starting_price"
            required
          />
        </div>
        <div class="col-md-3">
          <select class="form-control" id="currency" name="currency" required>
            <option value="ETH">ETH</option>
            <option disabled value="EUR">EUR</option>
            <option disabled value="USD">USD</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="reservePrice" class="col-md-4 col-form-label text-md-right">Reserve Price</label>

        <div class="col-md-6">
          <input id="reservePrice" type="text" class="form-control" name="reservePrice" required />
        </div>
      </div>

      <div class="form-group row">
        <label for="endDate" class="col-md-4 col-form-label text-md-right">End Date</label>

        <div class="col-md-6">
          <input
            id="endDate"
            type="text"
            class="form-control"
            name="endDate"
            maxlength="8"
            v-model="endDate"
            placeholder="DD/MM/YY"
            required
          />
        </div>
      </div>
      <div class="form-group row">
        <label for="sellerAddress" class="col-md-4 col-form-label text-md-right">ETH address</label>

        <div class="col-md-6">
          <input id="ethaddress" type="text" class="form-control" name="sellerAddress" readonly />
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
          <button class="btn btn-primary">Submit</button>
        </div>
      </div>

      <input type="hidden" id="contractAddress" name="contractAddress" />
      <input type="hidden" name="_token" :value="csrf" />
    </form>
    <div class="loader"></div>
  </div>
</template>

<script>
import contractABI from "../contractABI";
export default {
  data() {
    return {
      endDate: null,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  methods: {
    createAuction: async function() {
      $("body").toggleClass("loading");
      console.log(this.endDate);
      //Convert endDate
      var partDate = this.endDate.split("/");
      partDate[2] = "20" + partDate[2];
      partDate[1] = partDate[1] - 1;
      var endingDate =
        new Date(partDate[2], partDate[1], partDate[0]).getTime() / 1000;
      console.log(endingDate);
      var startingDate = parseInt(new Date().getTime() / 1000);
      var duration = endingDate - startingDate;
      console.log(duration);
      if (duration < 0) {
        alert("Select a differnt ending date");
        $("body").toggleClass("loading");
        return;
      }
      var currentBlockNumber = await web3.eth.getBlockNumber();
      var blockDuration = 13;
      var endingBlockNumber = currentBlockNumber + duration / blockDuration;
      console.log(endingBlockNumber);

      var contract = new web3.eth.Contract(contractABI);

      let owner = (await web3.eth.getAccounts())[0];
      let title = "title";
      let startprice = 100;
      let reserveprice = 120;

      let description = "description";

      if ($("#loader").is(":visible")) {
        window.addEventListener("beforeunload", event => {
          event.returnValue = `Are you sure you want to leave?`;
        });
      }
      //CHANGE DATA BYTECODE ON CONTRACT UPDATE!!!!!!!!!!!!!!!!!!!!!!!!!!
      contract
        .deploy({
          data:
            "0x60806040523480156200001157600080fd5b5060405162000ce338038062000ce3833981018060405260808110156200003757600080fd5b810190808051906020019092919080516401000000008111156200005a57600080fd5b828101905060208101848111156200007157600080fd5b81518560018202830111640100000000821117156200008f57600080fd5b5050929190602001805190602001909291908051640100000000811115620000b657600080fd5b82810190506020810184811115620000cd57600080fd5b8151856001820283011164010000000082111715620000eb57600080fd5b5050929190505050836000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff16021790555082600190805190602001906200014b9291906200019b565b508160028190555080600390805190602001906200016b9291906200019b565b506001600460006101000a81548160ff021916908360028111156200018c57fe5b0217905550505050506200024a565b828054600181600116156101000203166002900490600052602060002090601f016020900481019282601f10620001de57805160ff19168380011785556200020f565b828001600101855582156200020f579182015b828111156200020e578251825591602001919060010190620001f1565b5b5090506200021e919062000222565b5090565b6200024791905b808211156200024357600081600090555060010162000229565b5090565b90565b610a89806200025a6000396000f3fe60806040526004361061007d576000357c0100000000000000000000000000000000000000000000000000000000900480630e8670e01461008257806362ea82db146100ad5780637fb450991461011257806391f901571461014b578063c8287b58146101a2578063ecfc7ecc146102ba578063f77282ab146102dc575b600080fd5b34801561008e57600080fd5b506100976102f3565b6040518082815260200191505060405180910390f35b3480156100b957600080fd5b506100fc600480360360208110156100d057600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291905050506102f9565b6040518082815260200191505060405180910390f35b34801561011e57600080fd5b50610127610311565b6040518082600281111561013757fe5b60ff16815260200191505060405180910390f35b34801561015757600080fd5b50610160610324565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b3480156101ae57600080fd5b506101b761034a565b6040518080602001858152602001806020018460028111156101d557fe5b60ff168152602001838103835287818151815260200191508051906020019080838360005b838110156102155780820151818401526020810190506101fa565b50505050905090810190601f1680156102425780820380516001836020036101000a031916815260200191505b50838103825285818151815260200191508051906020019080838360005b8381101561027b578082015181840152602081019050610260565b50505050905090810190601f1680156102a85780820380516001836020036101000a031916815260200191505b50965050505050505060405180910390f35b6102c26104af565b604051808215151515815260200191505060405180910390f35b3480156102e857600080fd5b506102f1610729565b005b60055481565b60076020528060005260406000206000915090505481565b600460009054906101000a900460ff1681565b600660009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b606060006060600060016002546003600460009054906101000a900460ff16838054600181600116156101000203166002900480601f0160208091040260200160405190810160405280929190818152602001828054600181600116156101000203166002900480156103fe5780601f106103d3576101008083540402835291602001916103fe565b820191906000526020600020905b8154815290600101906020018083116103e157829003601f168201915b50505050509350818054600181600116156101000203166002900480601f01602080910402602001604051908101604052809291908181526020018280546001816001161561010002031660029004801561049a5780601f1061046f5761010080835404028352916020019161049a565b820191906000526020600020905b81548152906001019060200180831161047d57829003601f168201915b50505050509150935093509350935090919293565b6000600160028111156104be57fe5b600460009054906101000a900460ff1660028111156104d957fe5b14151561054e576040517f08c379a00000000000000000000000000000000000000000000000000000000081526004018080602001828103825260178152602001807f41756374696f6e206d7573742062652072756e6e696e6700000000000000000081525060200191505060405180910390fd5b6000341115156105c6576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252600e8152602001807f43616e277420626520656d70747900000000000000000000000000000000000081525060200191505060405180910390fd5b600061061a34600760003373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020546109d390919063ffffffff16565b905060055481111515610695576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601b8152602001807f43757272656e7420626964203e2068696768657374207072696365000000000081525060200191505060405180910390fd5b80600760003373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020819055508060058190555033600660006101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff160217905550600191505090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614806107c357506000600760003373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200190815260200160002054115b15156107ce57600080fd5b6000806000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161415610854576000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff169150600554905061091f565b600660009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614156108d857600660009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1691506000905061091e565b339150600760003373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020019081526020016000205490505b5b6000600760003373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001908152602001600020819055508173ffffffffffffffffffffffffffffffffffffffff166108fc829081150290604051600060405180830381858888f193505050501580156109aa573d6000803e3d6000fd5b506002600460006101000a81548160ff021916908360028111156109ca57fe5b02179055505050565b6000808284019050838110151515610a53576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601b8152602001807f536166654d6174683a206164646974696f6e206f766572666c6f77000000000081525060200191505060405180910390fd5b809150509291505056fea165627a7a723058201e54c2d973e59851b3d3723f221edbc8bdb781d1ecd4dbb493b989f3858639f50029",
          arguments: [
            owner,
            title,
            id,
            startprice,
            reserveprice,
            endingBlockNumber
          ]
        })
        .send(
          {
            from: owner
          },
          function(error, transactionHash) {
            console.log(transactionHash);
            if (error) {
              $("body").toggleClass("loading");
            }
          }
        )
        .then(function(newContractInstance) {
          console.log(newContractInstance.options.address); // instance with the new contract address
          $("#contractAddress").val(newContractInstance.options.address);
          document.getElementById("createauction").submit();
          $("body").toggleClass("loading");
        });
    }
  }
};
</script>

<style>
.loader {
  display: none;
  position: fixed;
  z-index: 1000;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(255, 255, 255, 0.8)
    url("https://loading.io/spinners/blocks/lg.rotating-squares-preloader-gif.gif")
    50% 50% no-repeat;
}
body.loading {
  overflow: hidden;
}
body.loading .loader {
  display: block;
}
</style>