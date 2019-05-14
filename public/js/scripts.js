App = {
    loading: false,

    load: async () => {
        await App.loadWeb3()
        await App.loadAccount()
    },

    loadWeb3: async () => {
        if (typeof web3 !== 'undefined') {
            App.web3Provider = web3.currentProvider
            web3 = new Web3(web3.currentProvider)
        } else {
            window.alert("Please connect to Metamask.")
        }
        // Modern dapp browsers...
        if (window.ethereum) {
            window.web3 = new Web3(ethereum)
            try {
                // Request account access if needed
                await ethereum.enable()
                // Acccounts now exposed
                initPayButton()
                web3.eth.sendTransaction({
                    /* ... */
                })
            } catch (error) {
                // User denied account access...
            }
        }
        // Legacy dapp browsers...
        else if (window.web3) {
            App.web3Provider = web3.currentProvider
            window.web3 = new Web3(web3.currentProvider)
            // Acccounts always exposed
            web3.eth.sendTransaction({
                /* ... */
            })
        }
        // Non-dapp browsers...
        else {
            console.log('Non-Ethereum browser detected. You should consider trying MetaMask!')
        }
    },

    loadAccount: async () => {
        // Set the current blockchain account
        App.account = web3.eth.accounts[0]
        $('#account').html(App.account)
        $('#ethaddress').val(App.account);
    },

}

$(document).ready(function () {
    App.load();
});

const initPayButton = () => {
    $('.pay-button').click(() => {
        // paymentAddress is where funds will be send to
        const paymentAddress = '0x95Cc4c3938de9f3406E0F0F91Ca2667A7BfeE203'
        const amountEth = 0.001
        web3.eth.sendTransaction({
            to: paymentAddress,
            value: web3.toWei(amountEth, 'ether')
        }, (err, transactionId) => {
            if (err) {
                console.log('Payment failed', err)
                $('#status').html('Payment failed')
            } else {
                console.log('Payment successful', transactionId)
                $('#status').html('Payment successful').attr('class', 'alert alert-success')
            }
        })
    })
}
