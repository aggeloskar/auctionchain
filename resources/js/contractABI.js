var contractABI = [{
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
        outputs: [{
            name: "",
            type: "bool"
        }],
        payable: true,
        stateMutability: "payable",
        type: "function"
    },
    {
        inputs: [{
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
        outputs: [{
            name: "",
            type: "uint8"
        }],
        payable: false,
        stateMutability: "view",
        type: "function"
    },
    {
        constant: true,
        inputs: [{
            name: "",
            type: "address"
        }],
        name: "bids",
        outputs: [{
            name: "",
            type: "uint256"
        }],
        payable: false,
        stateMutability: "view",
        type: "function"
    },
    {
        constant: true,
        inputs: [],
        name: "highestBidder",
        outputs: [{
            name: "",
            type: "address"
        }],
        payable: false,
        stateMutability: "view",
        type: "function"
    },
    {
        constant: true,
        inputs: [],
        name: "highestPrice",
        outputs: [{
            name: "",
            type: "uint256"
        }],
        payable: false,
        stateMutability: "view",
        type: "function"
    },
    {
        constant: true,
        inputs: [],
        name: "returnContents",
        outputs: [{
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
]

export default contractABI;
