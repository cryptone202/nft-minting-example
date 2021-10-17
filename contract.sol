// SPDX-License-Identifier: MIT
/*
,------.         ,--.                      ,------.         ,--.       ,--.     ,--.                
|  .-.  \ ,--.--.`--' ,---.  ,---.,--. ,--.|  .-.  \  ,---. |  | ,---. |  ,---. `--',--,--,  ,---.  
|  |  \  :|  .--',--.| .-. || .-. |\  '  / |  |  \  :| .-. ||  || .-. ||  .-.  |,--.|      \(  .-'  
|  '--'  /|  |   |  || '-' '| '-' ' \   '  |  '--'  /' '-' '|  || '-' '|  | |  ||  ||  ||  |.-'  `) 
`-------' `--'   `--'|  |-' |  |-'.-'  /   `-------'  `---' `--'|  |-' `--' `--'`--'`--''--'`----'  
                     `--'   `--'  `---'                         `--'                                

 - This contract was made by Jefff, as an example for a simple NFT solution, without any fancy gimicks. -
*/
pragma solidity ^0.8.0;

import "@openzeppelin/contracts/token/ERC721/extensions/ERC721Enumerable.sol";
import "@openzeppelin/contracts/access/Ownable.sol";
import "@openzeppelin/contracts/utils/Counters.sol";

contract DrippyDolphins is ERC721Enumerable, Ownable {
    using Address for address;
    using Counters for Counters.Counter;

    Counters.Counter private _tokenCount; 
    
    /* Initial Values */
    string public baseURI;
    bool public saleIsActive = false;
    uint256 public constant price = 80000000000000000; // 0.080000000000000000 ETH
    
    /* Mappings */
    mapping(address => uint256) public minted; 
    
    /* Constructor Arguements- set only on deployment */
    constructor(string memory baseURl) ERC721("Drippy Dolphins", "DD") {
        setBaseURI(baseURl);
    }

    /* Return a Value */
    function _baseURI() internal view override returns (string memory) {
        return baseURI;
    }

    /* Set a value */
    function setBaseURI(string memory __baseURI) public onlyOwner {
        baseURI = __baseURI;
    }
    
    function flipSaleState() public onlyOwner {
        saleIsActive = !saleIsActive;
    }

    /* Functions */
    function mint(uint256 _amount) external payable {
        require(saleIsActive, "Sale must be active");
        require(!Address.isContract(msg.sender), "Contracts are not allowed to mint");
        require(minted[msg.sender] + _amount <= 10, "Purchase would exceed max tokens per wallet");
        require(_tokenCount.current() + _amount <= 10000, "Purchase would exceed max supply of tokens");
        require(msg.value >= price * _amount, "Ether value sent is not correct");


        for(uint i; i < _amount; i++) {
            _tokenCount.increment();
            _safeMint(msg.sender, _tokenCount.current());
        }

        minted[msg.sender] += _amount;
    }
    
    /* withdraw */
    function withdraw() external onlyOwner {
        uint balance = address(this).balance;
        payable(msg.sender).transfer(balance);
    }

}