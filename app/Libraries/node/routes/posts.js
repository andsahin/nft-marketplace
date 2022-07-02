import express from "express";
import {
  createWallet,
  privateKeyEncrypt,
  privateKeyDycrypt,
  privateKeyToAddress,
  getBalance,
  getTokenBalance,
  getTokenInfo,
  getWalletNonce,
  isValidWallet,
} from "../controllers/signin.js";
import {
  sendBaseCoin,
  getTransactionFee,
  sendToken,
  getTransactionReceipt,
  getTokenIdFromTrx,
  getTransaction,
  transferNftToken,
  contractDeploy,
  setContract,
  mintNft,
  getTokenUri,
  buyItems,
  listingToken,
  unListingToken,
  transferNft
} from "../controllers/web3api.js";

const router = express.Router();

router.post("/account/createWallet", createWallet);
router.post("/account/privateKeyEncrypt", privateKeyEncrypt);
router.post("/account/privateKeyDycrypt", privateKeyDycrypt);
router.post("/account/privateKeyToAddress", privateKeyToAddress);
router.post("/account/getBalance", getBalance);
router.post("/account/getTokenBalance", getTokenBalance);
router.post("/account/getTokenInfo", getTokenInfo);
router.post("/account/getWalletNonce", getWalletNonce);
router.post("/account/isValidWallet", isValidWallet);


router.post("/transaction/sendBaseCoin", sendBaseCoin);
router.post("/transaction/sendToken", sendToken);
router.post("/transaction/getTransactionFee", getTransactionFee);
router.post("/transaction/getTransactionReceipt", getTransactionReceipt);
router.post("/transaction/getTokenIdFromTrx", getTokenIdFromTrx);
router.post("/transaction/getTransaction", getTransaction);
router.post("/transaction/transferNftToken", transferNftToken);
router.post("/transaction/contractDeploy", contractDeploy);
router.post("/transaction/setContract", setContract);
router.post("/transaction/mintNft", mintNft);
router.post("/transaction/getTokenUri", getTokenUri);
router.post("/transaction/buyItems", buyItems);
router.post("/transaction/listingToken", listingToken);
router.post("/transaction/unListingToken", unListingToken);
router.post("/transaction/transferNft", transferNft);

export default router;  
