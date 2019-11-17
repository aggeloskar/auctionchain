var contractABI = [
    {
        constant: true,
        inputs: [
            {
                internalType: "address",
                name: "",
                type: "address"
            }
        ],
        name: "bids",
        outputs: [
            {
                internalType: "uint256",
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
        name: "auctionState",
        outputs: [
            {
                internalType: "enum Auction.State",
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
        inputs: [],
        name: "highestBidder",
        outputs: [
            {
                internalType: "address payable",
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
        name: "returnContents",
        outputs: [
            {
                internalType: "string",
                name: "",
                type: "string"
            },
            {
                internalType: "uint256",
                name: "",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "",
                type: "uint256"
            },
            {
                internalType: "enum Auction.State",
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
        inputs: [],
        name: "highestBid",
        outputs: [
            {
                internalType: "uint256",
                name: "",
                type: "uint256"
            }
        ],
        payable: false,
        stateMutability: "view",
        type: "function"
    },
    {
        constant: false,
        inputs: [],
        name: "placeBid",
        outputs: [
            {
                internalType: "bool",
                name: "",
                type: "bool"
            }
        ],
        payable: true,
        stateMutability: "payable",
        type: "function"
    },
    {
        constant: false,
        inputs: [],
        name: "endAuction",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function"
    },
    {
        inputs: [
            {
                internalType: "address payable",
                name: "_owner",
                type: "address"
            },
            {
                internalType: "string",
                name: "_title",
                type: "string"
            },
            {
                internalType: "uint256",
                name: "_id",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "_startPrice",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "_reservePrice",
                type: "uint256"
            },
            {
                internalType: "uint256",
                name: "_endBlock",
                type: "uint256"
            }
        ],
        payable: false,
        stateMutability: "nonpayable",
        type: "constructor"
    }
];

export default contractABI;
