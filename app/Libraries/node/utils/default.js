import Web3 from "web3";
import Common from "ethereumjs-common";
import {
  BSC_RPC_URL,
  ETHER_RPC_URL,
  BSC_NETWORK,
  ETHER_NETWORK,
} from "../constants/allConstants.js";

function getWeb3(NETWORK) {
  
  if (NETWORK == "bsc") {

    return new Web3(new Web3.providers.HttpProvider(BSC_RPC_URL.MAINHOST10));

  } else if(NETWORK == "bsc-testnet"){

    return new Web3(new Web3.providers.HttpProvider(BSC_RPC_URL.TESTHOST1));

  } else if(NETWORK == "eth") {

    return new Web3(new Web3.providers.HttpProvider(ETHER_RPC_URL.MAINNET));

  }else{

    return new Web3(new Web3.providers.HttpProvider(ETHER_RPC_URL.TESTNET));

  }

}


function commonNetwork(NETWORK) {
  if (NETWORK == "bsc") {

    return Common.default.forCustomChain(
      "mainnet",
      {
        name: "BNB",
        networkId: BSC_NETWORK.MAINNET_CHAIN,
        chainId: BSC_NETWORK.MAINNET_CHAIN,
      },
      "petersburg"
    );

  } else if(NETWORK == "bsc-testnet"){

    return Common.default.forCustomChain(
      "ropsten",
      {
        name: "Binance Smart Chain Testnet",
        networkId: BSC_NETWORK.TESTNET_CHAIN,
        chainId: BSC_NETWORK.TESTNET_CHAIN,
      },
      "petersburg"
    );

  } else {
    return Common.default.forCustomChain(
      "ropsten",
      {
        name: "ETH",
        networkId: ETHER_NETWORK.TESTNET_CHAIN,
        chainId: ETHER_NETWORK.TESTNET_CHAIN,
      },
      "petersburg"
    );
  }
}

function getChainId(NETWORK) {
  if (NETWORK == "bsc") {
    return BSC_NETWORK.MAINNET_CHAIN;
  } else {
    return ETHER_NETWORK.TESTNET_CHAIN;
  }
}

export { getWeb3, commonNetwork, getChainId };
