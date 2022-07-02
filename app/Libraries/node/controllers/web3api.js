import express from "express";
import stripHexPrefix from "strip-hex-prefix";
import scientificToDecimal from "scientific-to-decimal";
import transaction from "ethereumjs-tx";
import { ethers } from "ethers";

import { abi } from "../constants/abi.js";
import { nftabi } from "../constants/nftabi.js";
import { bytecode } from "../constants/bytecode.js";
import { GAS_LIMIT } from "../constants/allConstants.js";
import { toError, toSuccess } from "../constants/response.js";
import { getWeb3, commonNetwork, getChainId } from "../utils/default.js";

import {utils, BigNumber} from "ethers";


const router = express.Router();

export const sendBaseCoin = async (req, res) => {
  try {
    const { formAddress, sendAmount, toAddress, privateKey, netWork } =
      req.body;
    const common = commonNetwork(netWork);
    const chainId = getChainId(netWork);
    const web3 = getWeb3(netWork);
    let gasPrice = await web3.eth.getGasPrice();
    gasPrice = Math.round(parseFloat(gasPrice));
    const amountToSend = parseInt(sendAmount * 10 ** 18);
    const nonce = await web3.eth.getTransactionCount(formAddress);

    const rawTransaction = {
      from: formAddress,
      nonce: web3.utils.toHex(nonce),
      gasPrice: web3.utils.toHex(gasPrice),
      gasLimit: web3.utils.toHex(GAS_LIMIT.BASE),
      to: toAddress,
      value: web3.utils.toHex(amountToSend),
      chainId: chainId,
    };

    const privateKeyRemoveHex = stripHexPrefix(privateKey);
    const privateK = Buffer.from(privateKeyRemoveHex, "hex");
    const newTransaction = new transaction.Transaction(rawTransaction, {
      common,
    });

    newTransaction.sign(privateK);
    let txHash = "";
    web3.eth
      .sendSignedTransaction("0x" + newTransaction.serialize().toString("hex"))
      .on("transactionHash", (hash) => {
        txHash = hash;
        return toSuccess(res, {
          txHash: hash,
        });
      })
      .on("error", (err) => {
        if (txHash) {
          console.log(err.message);
        } else {
          return toError(res, err.message);
        }
      });
  } catch (error) {
    return toError(res, error.message);
  }
};
export const sendToken = async (req, res) => {
  try {
    const {
      formAddress,
      sendAmount,
      toAddress,
      privateKey,
      contractAddress,
      netWork,
    } = req.body;
    const web3 = getWeb3(netWork);
    const common = commonNetwork(netWork);
    const chainId = getChainId(netWork);
    let gasPrice = await web3.eth.getGasPrice();
    gasPrice = Math.round(parseFloat(gasPrice));
    const sendTokenAmount = web3.utils.toWei(sendAmount.toString()).toString();
    const nonce = await web3.eth.getTransactionCount(formAddress);
    const contractBuf = new web3.eth.Contract(abi, contractAddress);
    const txData = contractBuf.methods
      .transfer(toAddress, "" + sendTokenAmount)
      .encodeABI();

    const rawTransaction = {
      from: formAddress,
      nonce: web3.utils.toHex(nonce),
      gasPrice: web3.utils.toHex(gasPrice),
      gasLimit: web3.utils.toHex(GAS_LIMIT.TOKEN),
      to: contractAddress,
      data: txData,
      value: "0x0",
      chainId: chainId,
    };
    const privateKeyRemoveHex = stripHexPrefix(privateKey);
    const privateK = Buffer.from(privateKeyRemoveHex, "hex");
    const newTransaction = new transaction.Transaction(rawTransaction, {
      common,
    });
    newTransaction.sign(privateK);

    let txHash = "";
    web3.eth
      .sendSignedTransaction("0x" + newTransaction.serialize().toString("hex"))
      .on("transactionHash", (hash) => {
        txHash = hash;
        return toSuccess(res, {
          txHash,
        });
      })
      .on("receipt", (recipt) => {
        console.log({ recipt });
      })
      .on("error", (err) => {
        if (txHash) {
          console.log(err.message);
        } else {
          return toError(res, err.message);
        }
      });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const transferNftToken = async (req, res) => {
  
  try {
    const {
      formAddress,
      tokenID,
      toAddress,
      privateKey,
      contractAddress,
      netWork,
    } = req.body;

    const web3 = getWeb3(netWork);
    const common = commonNetwork(netWork);
    const chainId = getChainId(netWork);
    let gasPrice = await web3.eth.getGasPrice();
    gasPrice = Math.round(parseFloat(gasPrice));
    const nonce = await web3.eth.getTransactionCount(formAddress);
    const contractBuf = new web3.eth.Contract(nftabi, contractAddress);
    
    
    
    const txData = contractBuf.methods
      .transferFrom(formAddress, toAddress, tokenID)
      .encodeABI();
     
    const rawTransaction = {
      from: formAddress,
      nonce: web3.utils.toHex(nonce),
      gasPrice: web3.utils.toHex(gasPrice),
      gasLimit: web3.utils.toHex(GAS_LIMIT.TOKEN),
      to: contractAddress,
      data: txData,
      value: "0x0",
      chainId: chainId,
    };
    


    const privateK = Buffer.from(privateKey, "hex");
    const newTransaction = new transaction.Transaction(rawTransaction, {
      common,
    });
    newTransaction.sign(privateK);

    let txHash = "";
    web3.eth
      .sendSignedTransaction("0x" + newTransaction.serialize().toString("hex"))
      .on("transactionHash", (hash) => {
        txHash = hash;
        console.log(txHash);
        return toSuccess(res, {
          txHash,
        });
      })
      .on("receipt", (recipt) => {

      })
      .on("error", (err) => {
        if (txHash) {
         
        } else { 
          return toError(res, err.message);
        }
      });
  } catch (error) { 
    return toError(res, error.message);
  }
};


export const getTransactionFee = async (req, res) => {
  try {
    const { netWork } = req.body;
    const web3 = getWeb3(netWork);
    const gasPrice = await web3.eth.getGasPrice();
    const gastotalprice = Math.round(parseFloat(gasPrice));
    const gaspriceval = scientificToDecimal(
      parseFloat(gastotalprice) / 10 ** 18
    );
    const txFees = gaspriceval * tokenGasLimit;
    return toSuccess(res, {
      txFees,
    });
  } catch (error) {
    return toError(res, error.message);
  }
};
export const getTransactionReceipt = async (req, res) => {
  try {
    const { txHash, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const result = await web3.eth.getTransactionReceipt(txHash);
    return toSuccess(res, result);
  } catch (error) {
    return toError(res, error.message);
  }
};

export const getTokenIdFromTrx = async (req, res) => {
  try {
    const { txHash, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const result = await web3.eth.getTransactionReceipt(txHash);
     
    if(result){
      return toSuccess(res, web3.utils.hexToNumber(result.logs[0].topics[3]));
    }else{
      return toError(res, 'Pending transaction please wait!');
    }
    
  } catch (error) {
    return toError(res, error.message);
  }
};
export const getTransaction = async (req, res) => {
  try {
    const { txHash, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const result = await web3.eth.getTransaction(txHash);
    return toSuccess(res, result);
  } catch (error) {
    return toError(res, error.message);
  }
};



export const contractDeploy = async (req, res) => {
  try {
    const { privateKey, contractName, contractSymbol, gotMaxTokenSupply, rpc_url} = req.body;


    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const network   = await provider.detectNetwork();
    const signer    = new ethers.Wallet(privateKey,provider); 
    const factory   = new ethers.ContractFactory(nftabi, bytecode, signer); 
    const contract    = await factory.deploy(contractName, contractSymbol, gotMaxTokenSupply);
    

    return toSuccess(res, contract);
  } catch (error) {
    return toError(res, error.message);
  }
};

export const setContract = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress} = req.body;
    const provider = new ethers.providers.JsonRpcProvider(rpc_url);

    const signer    = new ethers.Wallet(privateKey,provider);
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);
 

    const setContract = await contract.setSmartContractAddress(contractAddress);

    console.log(setContract);

    return toSuccess(res, setContract);
  } catch (error) {
    return toError(res, error.message);
  }
};

 

export const mintNft = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, tokenURI} = req.body;

    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const signer    = new ethers.Wallet(privateKey,provider); 
    const contract  = new ethers.Contract(contractAddress , nftabi , signer); 

    const item        = await contract.createMarketItem(tokenURI);
    const newId       = await contract.getNewCreatedTokenID();

    console.log(newId);

    return toSuccess(res, item);
  } catch (error) {
    return toError(res, error.message);
  }
};




export const listingToken = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, tokenID, price} = req.body;

    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const signer    = new ethers.Wallet(privateKey,provider);
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);

 
    let list      = await contract.listNftSale(tokenID, ethers.utils.parseUnits(price,"ether"), {gasLimit: 990000});
  
    console.log(list);

    return toSuccess(res, list);
  } catch (error) {
    return toError(res, error.message);
  }
};


export const unListingToken = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, tokenID } = req.body;

    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const signer    = new ethers.Wallet(privateKey,provider);
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);

 
    let unlist      = await contract.unlistNftSale(tokenID, {gasLimit: 320000});
  
    console.log(unlist);

    return toSuccess(res, unlist);
  } catch (error) {
    return toError(res, error.message);
  }
};




export const getTokenUri = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, tokenID} = req.body;
    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const signer    = new ethers.Wallet(privateKey,provider);
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);

 
    let gotURI      = await contract.fetchTokenIDURI(tokenID);
  
    console.log(gotURI);

    return toSuccess(res, gotURI);
  } catch (error) {
    return toError(res, error.message);
  }
};


export const buyItems = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, tokenID, sellPrice, fees} = req.body;
    const provider  = new ethers.providers.JsonRpcProvider(rpc_url);

    const signer    = new ethers.Wallet(privateKey,provider); 
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);
     

    let sellerGetsPercentage      = 100 - fees; //INPUT (Frontend)
     
    let sellerGets = ethers.utils.parseUnits((((sellerGetsPercentage*(parseFloat(sellPrice))))/100).toFixed(16).toString(), "ether"); //CALCULATE: Seller gets 98%
    let marketOwnerGets = ethers.utils.parseUnits((((fees*(parseFloat(sellPrice))))/100).toFixed(16).toString(), "ether"); //CALCULATE: Seller gets 98%
 
    let data = await contract.directBuyMarketItem(tokenID, ethers.utils.parseUnits(sellPrice,"ether"), sellerGets, marketOwnerGets, 
            {value: ethers.utils.parseUnits(sellPrice,"ether"), gasLimit: 250000}
        ); 
 

    return toSuccess(res, data);
  } catch (error) {
    return toError(res, error.message);
  }
};



export const transferNft = async (req, res) => {
  try {

    const { privateKey, rpc_url, contractAddress, recieverAddress, tokenID, transferFee } = req.body;

    const provider  = new ethers.providers.JsonRpcProvider(rpc_url); 
    const signer    = new ethers.Wallet(privateKey,provider);
    const contract  = new ethers.Contract(contractAddress , nftabi , signer);
    const fees      = ethers.utils.parseUnits(parseFloat(transferFee).toFixed(16).toString(), "ether");

    let txData      = await contract.transferMarketItem(recieverAddress, tokenID, fees, {value: fees, gasLimit: 320000});
   
    return toSuccess(res, txData);
  } catch (error) {
    return toError(res, error.message);
  }
};


export default router;
