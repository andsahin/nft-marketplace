import express from "express";
import util from "ethereumjs-util";
import BigNumber from "bignumber.js";

import { abi } from "../constants/abi.js";
import { nftabi } from "../constants/nftabi.js";
import { toError, toSuccess } from "../constants/response.js";
import { getWeb3 } from "../utils/default.js";



const router = express.Router();

export const createWallet = async (req, res) => {
  try {
    const { netWork } = req.body;
    const web3 = getWeb3(netWork);
    const account = web3.eth.accounts.create();
    return toSuccess(res, account);
  } catch (error) {
    return toError(res, error.message);
  }
};

export const privateKeyEncrypt = async (req, res) => {
  try {
    const { privateKey, password, netWork } = req.body;
    const web3 = getWeb3(netWork);

    const encryptData = web3.eth.accounts.encrypt(privateKey, password);
    return toSuccess(res, encryptData);
  } catch (error) {
    return toError(res, error.message);
  }
};

export const privateKeyDycrypt = async (req, res) => {
  try {
    const { netWork } = req.body;
    const web3 = getWeb3(netWork);

    const {
      version,
      id,
      address,
      ciphertext,
      iv,
      cipher,
      kdf,
      dklen,
      salt,
      n,
      r,
      p,
      mac,
      password,
    } = req.body;

    const decryptData = web3.eth.accounts.decrypt(
      {
        version: +version,
        id,
        address,
        crypto: {
          ciphertext,
          cipherparams: { iv },
          cipher,
          kdf,
          kdfparams: {
            dklen: +dklen,
            salt,
            n: +n,
            r: +r,
            p: +p,
          },
          mac,
        },
      },
      password
    );

    return toSuccess(res, decryptData);
  } catch (error) {
    return toError(res, error.message);
  }
};

export const privateKeyToAddress = async (req, res) => {
  try {
    const privKey = util.toBuffer(privateKey);
    const address = util.privateToAddress(privKey);
    const addressBuffer = util.bufferToHex(address);
    return toSuccess(res, { address: addressBuffer });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const getBalance = async (req, res) => {
  try {
    const { address, netWork } = req.body;
    const web3 = getWeb3(netWork);

    let balance = await web3.eth.getBalance(address);
    balance = parseFloat(balance) / 10 ** 18;

    return toSuccess(res, { balance });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const getTokenBalance = async (req, res) => {
  try {
    const { address, contractAddress, decimal, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const contractBuf = new web3.eth.Contract(abi, contractAddress);

    const result = await contractBuf.methods.balanceOf(address).call();
    const amount = new BigNumber(result);
    const tokenBalance = parseFloat(amount) / 10 ** decimal;
    return toSuccess(res, { tokenBalance });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const getTokenInfo = async (req, res) => {
  try {
    const { contractAddress, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const contractBuf = new web3.eth.Contract(abi, contractAddress);

    const tokenName = await contractBuf.methods.name().call();
    const tokenSymbol = await contractBuf.methods.symbol().call();
    const tokenDecimals = await contractBuf.methods.decimals().call();
    const tokenSupply = await contractBuf.methods.totalSupply().call();
    const supplyamount = new BigNumber(tokenSupply);
    const totalSupply = parseFloat(supplyamount) / 10 ** tokenDecimals;

    return toSuccess(res, {
      tokenName,
      tokenSymbol,
      tokenDecimals,
      tokenSupply: totalSupply,
    });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const getWalletNonce = async (req, res) => {
  try {
    const { formAddress, blockType, netWork } = req.body;
    const web3 = getWeb3(netWork);
    let nonce;

    if (blockType) {
      nonce = await web3.eth.getTransactionCount(formAddress, blockType);
    } else {
      nonce = await web3.eth.getTransactionCount(formAddress);
    }
    return toSuccess(res, { nonce });
  } catch (error) {
    return toError(res, error.message);
  }
};

export const isValidWallet = async (req, res) => {
  try {
    const { address, netWork } = req.body;
    const web3 = getWeb3(netWork);
    const wallet = web3.utils.isAddress(address);

    if (wallet) {
      return toSuccess(res, { wallet_status: "ok" });
    } else {
      return toError(res, "Invalid wallet address");
    }
  } catch (error) {
    return toError(res, error.message);
  }
};

export default router;
