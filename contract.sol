// SPDX-License-Identifier: <SPDX-License>" to each source file. Use "SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.0;

import "@openzeppelin/contracts/token/ERC721/extensions/ERC721Enumerable.sol";
import "@openzeppelin/contracts/token/ERC721/ERC721.sol";
import "@openzeppelin/contracts/token/ERC721/IERC721.sol";
import "@openzeppelin/contracts/token/ERC20/IERC20.sol";
import "@openzeppelin/contracts/access/Ownable.sol";

contract DrippyDolphins is ERC721Enumerable, Ownable {
    uint256 private basePrice = 99000000000000000; //0.099 ETH

    uint256 private reserveAtATime = 25;
    uint256 private reservedCount = 0;
    uint256 private maxReserveCount = 200;
    address private OwnerAddress = 0xCA9B2C3B584FC92cE20F0BB260124dF3Ad25Fc43; // Change this to yours.
    address private ProjectAddress = 0x435E71FF5f32682B30b4A95cD0B672457DabA776; 

    string _baseTokenURI;   
    
    bool public isActive = false;
    bool public isAllowListActive = false;
    
    uint256 public constant MAX_MINTSUPPLY = 20000; // Max Supply
    uint256 public maximumAllowedTokensPerPurchase = 20; // Maximum on full release
    uint256 public allowListMaxMint = 20; // Maximum on presale

    mapping(address => bool) private _allowList;
    mapping(address => uint256) private _allowListClaimed;

    event AssetMinted(uint256 tokenId, address sender);
    event SaleActivation(bool isActive);

    constructor(string memory baseURI) ERC721("DrippyDolphins", "GA") {
        setBaseURI(baseURI);
    }

    modifier saleIsOpen {
        require(totalSupply() <= MAX_MINTSUPPLY, "Sale has ended.");
        _;
    }

    modifier onlyAuthorized() {
        require(OwnerAddress == msg.sender || owner() == msg.sender);
        _;
    }

    function setMaximumAllowedTokens(uint256 _count) public onlyAuthorized {
        maximumAllowedTokensPerPurchase = _count;
    }

    function setActive(bool val) public onlyAuthorized {
        isActive = val;
        emit SaleActivation(val);
    }

    function setIsAllowListActive(bool _isAllowListActive) external onlyAuthorized {
        isAllowListActive = _isAllowListActive;
    }

    function setAllowListMaxMint(uint256 maxMint) external onlyAuthorized {
        allowListMaxMint = maxMint;
    }

    function addToAllowList(address[] calldata addresses) external onlyAuthorized {
      for (uint256 i = 0; i < addresses.length; i++) {
        require(addresses[i] != address(0), "Can't add a null address");

        _allowList[addresses[i]] = true;
        _allowListClaimed[addresses[i]] > 0 ? _allowListClaimed[addresses[i]] : 0;
      }
    }

    function checkIfOnAllowList(address addr) external view returns (bool) {
      return _allowList[addr];
    }

    function removeFromAllowList(address[] calldata addresses) external onlyAuthorized {
      for (uint256 i = 0; i < addresses.length; i++) {
        require(addresses[i] != address(0), "Can't add a null address");

        _allowList[addresses[i]] = false;
      }
    }

    function allowListClaimedBy(address owner) external view returns (uint256){
      require(owner != address(0), 'Zero address not on Allow List');

      return _allowListClaimed[owner];
    }
    
    function setReserveAtATime(uint256 val) public onlyAuthorized {
        reserveAtATime = val;
    }

    function setMaxReserve(uint256 val) public onlyAuthorized {
        maxReserveCount = val;
    }
    
    function setPrice(uint256 _price) public onlyAuthorized {
        basePrice = _price;
    }
    
    function setBaseURI(string memory baseURI) public onlyAuthorized {
        _baseTokenURI = baseURI;
    }

    function getMaximumAllowedTokens() public view onlyAuthorized returns (uint256) {
        return maximumAllowedTokensPerPurchase;
    }

    function getPrice() external view returns (uint256) {
        return basePrice; 
    }

    function getReserveAtATime() external view returns (uint256) {
        return reserveAtATime; 
    }

    function getTotalSupply() external view returns (uint256) {
        return totalSupply();
    }

    function getContractOwner() public view returns (address) {    
        return owner();
    }

    function _baseURI() internal view virtual override returns (string memory) {
        return _baseTokenURI;
    }

    function reserveNft() public onlyAuthorized {
        require(reservedCount <= maxReserveCount, "Max Reserves taken already!");
        uint256 supply = totalSupply();
        uint256 i;
        for (i = 0; i < reserveAtATime; i++) {
            emit AssetMinted(supply + i, msg.sender);
            _safeMint(msg.sender, supply + i);
            reservedCount++;
        }  
    }

    function mint(address _to, uint256 _count) public payable saleIsOpen {
        if (msg.sender != owner()) {
            require(isActive, "Sale is not active currently.");
        }
        
        require(totalSupply() + _count <= MAX_MINTSUPPLY, "Total supply exceeded.");
        require(totalSupply() <= MAX_MINTSUPPLY, "Total supply spent.");
        require(
            _count <= maximumAllowedTokensPerPurchase,
            "Exceeds maximum allowed tokens"
        );
        require(msg.value >= basePrice * _count, "Insuffient ETH amount sent.");

        for (uint256 i = 0; i < _count; i++) {
            emit AssetMinted(totalSupply(), _to);
            _safeMint(_to, totalSupply());
        }
    }

  function preSaleMint(uint256 _count) public payable saleIsOpen {
    require(isAllowListActive, 'Allow List is not active');
    require(_allowList[msg.sender], 'You are not on the Allow List');
    require(totalSupply() < MAX_MINTSUPPLY, 'All tokens have been minted');
    require(_count <= allowListMaxMint, 'Cannot purchase this many tokens');
    require(_allowListClaimed[msg.sender] + _count <= allowListMaxMint, 'Purchase exceeds max allowed');
    require(msg.value >= basePri    ce * _count, 'Insuffient ETH amount sent.');

    for (uint256 i = 0; i < _count; i++) {
      _allowListClaimed[msg.sender] += 1;
      emit AssetMinted(totalSupply(), msg.sender);
      _safeMint(msg.sender, totalSupply());
    }
  }

  function withdraw() external onlyAuthorized {
    uint balance = address(this).balance;
    payable(OwnerAddress).transfer(balance);
    payable(owner()).transfer(address(this).balance);
  }
}