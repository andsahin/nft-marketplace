// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.4;

import '@openzeppelin/contracts/token/ERC721/ERC721.sol';
import '@openzeppelin/contracts/utils/Counters.sol';
import '@openzeppelin/contracts/security/ReentrancyGuard.sol';
import '@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol';

contract NFTMarketplace is ReentrancyGuard, ERC721URIStorage{
    
    using Counters for Counters.Counter;
    Counters.Counter private _tokenIds;
    address _scAddress;
    string public _tokenName;
    string public _tokenSymbol;
    uint256 private _maxTokenSupply;
    address payable owner;
    mapping (uint256 => string) _tokenIDURI;

    struct MarketItem {
        uint256 tokenId;
        address nftContract;
        string uri;
        address payable nftCreator;
        address payable nftOwner;
        uint256 price;
        bool forSale;
    }

    mapping(uint256 => MarketItem) private MarketItemDatabase;

    event MarketItemCreated(
        uint256 indexed tokenId,
        address indexed nftContract,
        string uri,
        address creator,
        address owner,
        uint256 price,
        bool forSale
    );

    constructor(string memory tokenName, string memory tokenSymbol, uint256 gotMaxTokenSupply) ERC721(tokenName, tokenSymbol){
        owner = payable(msg.sender);
        require(gotMaxTokenSupply > 0, "Max token supply needs to be greater than 0.");
        _maxTokenSupply = gotMaxTokenSupply;
        _tokenName = tokenName;
        _tokenSymbol = tokenSymbol;
    }

    function totalSupply() public view returns (uint256){
        return (_maxTokenSupply);
    }

    function setSmartContractAddress(address scAddress) public{
        _scAddress = scAddress;
    }

    function getNewCreatedTokenID() public view returns (uint256){
        return _tokenIds.current();
    }

    function setMaxTokenSupply(uint256 gotNewMaxTokenSupply) public {
        require(msg.sender == owner, "Only owner can set the max token supply");
        require(gotNewMaxTokenSupply > _maxTokenSupply, "New max token supply needs to be greater than previous Max Token Supply.");
        _maxTokenSupply = gotNewMaxTokenSupply;
    }

    function fetchTokenIDURI(uint256 tokenID) public view returns (string memory){

        bytes memory tempTokenURI = bytes(_tokenIDURI[tokenID]);
        if(tempTokenURI.length != 0){
            return _tokenIDURI[tokenID];
        } else
            return "Token ID does not exist";
        
    }

    //NEW CREATE MARKET ITEM
    function createMarketItem(string memory uri) public payable nonReentrant{
        require(_tokenIds.current() != _maxTokenSupply, "MAHTKN Token has reached it's max supply limit");
        _tokenIds.increment();
        uint256 newTokenId = _tokenIds.current();
        _mint(msg.sender, newTokenId);
        _setTokenURI(newTokenId, uri);
        _tokenIDURI[newTokenId] = uri;

        MarketItemDatabase[newTokenId] = MarketItem(
            newTokenId, 
            _scAddress, 
            uri,
            payable(msg.sender), 
            payable(address(0)), 
            0,
            false
        );
        
        emit MarketItemCreated(
            newTokenId, 
            _scAddress, 
            uri,
            msg.sender, 
            address(0), 
            0,
            false
        );
    }

    function listNftSale(uint256 tokenId, uint256 price) public {
        require((msg.sender == MarketItemDatabase[tokenId].nftCreator && MarketItemDatabase[tokenId].nftOwner == address(0)) || msg.sender == MarketItemDatabase[tokenId].nftOwner, "You are not the owner of this Item");
        setApprovalForAll(_scAddress, true);
        MarketItemDatabase[tokenId].forSale = true;
        MarketItemDatabase[tokenId].price = price;
        IERC721(_scAddress).transferFrom(msg.sender, address(this), tokenId);
    }

    function unlistNftSale(uint256 tokenId) public {
        require((msg.sender == MarketItemDatabase[tokenId].nftCreator && MarketItemDatabase[tokenId].nftOwner == address(0)) || msg.sender == MarketItemDatabase[tokenId].nftOwner, "You are not the owner of this Item");
        require(MarketItemDatabase[tokenId].forSale == true, "NFT is already not listed for sale");
        setApprovalForAll(_scAddress, true);
        MarketItemDatabase[tokenId].forSale = false;
        MarketItemDatabase[tokenId].price = 0;
        IERC721(_scAddress).transferFrom(address(this), msg.sender, tokenId);
    }

    function directBuyMarketItem(uint256 tokenId, uint256 marketItemPrice, uint256 sellerGets, uint256 marketOwnerGets) public payable nonReentrant{

        require(MarketItemDatabase[tokenId].forSale == true, "NFT not listed for sale.");
        require(msg.value == marketItemPrice, "Please pay asking price!");

        if(MarketItemDatabase[tokenId].nftOwner == address(0)){
            MarketItemDatabase[tokenId].nftCreator.transfer(sellerGets);
        } else if((MarketItemDatabase[tokenId].nftOwner != address(0)))
        {
            MarketItemDatabase[tokenId].nftOwner.transfer(sellerGets);
        }
        
        IERC721(_scAddress).transferFrom(address(this), msg.sender, tokenId);
        MarketItemDatabase[tokenId].nftOwner = payable(msg.sender);
        MarketItemDatabase[tokenId].forSale = false;
        MarketItemDatabase[tokenId].price = 0;
        payable(owner).transfer(marketOwnerGets);
    }

    function transferMarketItem(address recieverAddress, uint256 tokenId, uint256 gotTransferFee) public payable nonReentrant{
        require((msg.sender == MarketItemDatabase[tokenId].nftCreator && MarketItemDatabase[tokenId].nftOwner == address(0)) || msg.sender == MarketItemDatabase[tokenId].nftOwner, "You are not the owner of this Item");
        require(MarketItemDatabase[tokenId].forSale == false, "You must take down marketplace listing before attempting to transfer.");
        require(msg.value == gotTransferFee, "Please pay the transfer fee.");
        setApprovalForAll(_scAddress, true);
        MarketItemDatabase[tokenId].nftOwner = payable(recieverAddress);
        payable(owner).transfer(gotTransferFee);
        IERC721(_scAddress).transferFrom(msg.sender, recieverAddress, tokenId);
    }

    function fetchWalletAddressURIs(address walletAddress) public view returns (string[] memory){

        uint256 totalItemCount = _tokenIds.current();
        uint256 uriCount = 0;
        
        uint256 currentIndex = 0;
        for(uint256 i=0; i<totalItemCount; i++){

            if(MarketItemDatabase[i+1].nftCreator == walletAddress && MarketItemDatabase[i+1].nftOwner == address(0) || MarketItemDatabase[i+1].nftOwner == walletAddress){
                uriCount +=1;
            }
        }

        string[] memory uris = new string[](uriCount);
        for(uint256 i=0; i<totalItemCount; i++){

            if(MarketItemDatabase[i+1].nftCreator == walletAddress && MarketItemDatabase[i+1].nftOwner == address(0) || MarketItemDatabase[i+1].nftOwner == walletAddress){
                string memory currentURI = MarketItemDatabase[i+1].uri;
                uris[currentIndex] = currentURI;
                currentIndex +=1;
            }

        }

        return uris;
    }
    
}