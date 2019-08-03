/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

var Web3 = require("web3");
if (window.ethereum) {
    window.web3 = new Web3(ethereum);
    try {
        // Request account access if needed
        ethereum.enable();
    } catch (error) {
        // User denied account access...
    }
} else if (window.web3) {
    // Legacy dapp browsers...
    window.web3 = new Web3(web3.currentProvider);
} else {
    // Non-dapp browsers...
    console.log(
        "Non-Ethereum browser detected. You should consider trying MetaMask!"
    );
}
console.log("Web3 version: " + web3.version);
export default web3;

async function getAccounts() {
    let account = (await web3.eth.getAccounts())[0];
    $("#account").html(account);
    let balance = await web3.eth.getBalance(account);
    let balanceEth = web3.utils.fromWei(balance, 'ether');
    balanceEth = parseFloat(balanceEth).toFixed(4);
    $("#balance").html(balanceEth + " ETH");
    let networkType = await web3.eth.net.getNetworkType();
    $("#network").html(networkType);
}
getAccounts();

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component("time-left", require("./components/TimeLeft.vue").default);
Vue.component("place-bid", require("./components/PlaceBid.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
