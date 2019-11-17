pragma solidity ^0.5.11;
import "https://raw.githubusercontent.com/OpenZeppelin/openzeppelin-contracts/master/contracts/math/SafeMath.sol";

contract Auction {
    using SafeMath for uint256;
    address payable private owner;
    string title;
    uint id;
    uint startPrice;
    uint reservePrice;
    uint endBlock;
    
    enum State{Default, Active, Ended}
    State public auctionState;

    uint public highestBid;
    address payable public highestBidder;
    mapping(address => uint) public bids;

    constructor(
        address payable _owner,
        string memory _title,
        uint _id,
        uint _startPrice,
        uint _reservePrice,
        uint _endBlock
        ) public {
        owner = _owner;
        title = _title;
        id = _id;
        startPrice = _startPrice;
        reservePrice = _reservePrice;
        endBlock = _endBlock;
        require(block.number <= endBlock, "endDate must be in the future.");
        auctionState = State.Active;
    }

    modifier notOwner(){
        require(msg.sender != owner, "Can't be owner");
        _;
    }
      
    function placeBid() public payable notOwner returns(bool) {
        require(auctionState == State.Active, "Auction must be active");
        require(block.number < endBlock, "Ending block already mined");
        require(msg.value > 0, "Can't be empty");
        uint currentBid = bids[msg.sender].add(msg.value);
        require(currentBid > highestBid, "Current bid > highest price");
        bids[msg.sender] = currentBid;
        highestBid = currentBid;
        highestBidder = msg.sender;
        return true;
    }
    
    function endAuction() public{
        require(block.number > endBlock, "Ending block already mined");
       
        address payable recipiant;
        uint value;
        
        if(msg.sender == owner && highestBid > reservePrice){
            recipiant = owner;
            value = highestBid;
        }
        else if (msg.sender == highestBidder && highestBid > reservePrice){
            recipiant = highestBidder;
            value = 0;
        }
        else {
            recipiant = msg.sender;
            value = bids[msg.sender];
        }
        // initialize the value
        bids[msg.sender] = 0;
        recipiant.transfer(value);
        auctionState = State.Ended;
    }
    
    function returnContents() public view returns(
        string memory,
        uint,
        uint,
        uint,
        uint,
        State
        ) {
        return (
            title,
            id,
            startPrice,
            reservePrice,
            endBlock,
            auctionState
        );
    }
    
}