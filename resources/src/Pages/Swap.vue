<template>
    <div>
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12 col-12"></div>
            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Swap</h4>
                    </div>
                    <div id="form">
                        <div class="card-body">
                            <div
                                class="d-flex justify-content-between align-items-center rounded shadow darked"
                            >
                                <button
                                    class="btn btn-flat-info dropdown-toggle ms-1 w-50 d-flex justify-content-between align-items-center"
                                    type="button"
                                    id="from_token_select"
                                    @click="openModal('from')"
                                >
                                    <img
                                        class="token_image hidden"
                                        height="36px"
                                        width="36px"
                                        id="from_token_img"
                                    />
                                    <span id="from_token_text"
                                        >Select Coin</span
                                    >
                                </button>
                                <div class="swapbox_select w-50 m-1">
                                    <input
                                        class="number form-control"
                                        placeholder="amount"
                                        id="from_amount"
                                        @click="getQuote"
                                    />
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center my-1 rounded shadow darked"
                            >
                                <button
                                    class="btn btn-flat-info dropdown-toggle ms-1 w-50 d-flex justify-content-between align-items-center"
                                    type="button"
                                    id="to_token_select"
                                    @click="openModal('to')"
                                >
                                    <img
                                        class="token_image hidden"
                                        height="36px"
                                        width="36px"
                                        id="to_token_img"
                                    />
                                    <span id="to_token_text">Select Coin</span>
                                </button>
                                <div class="swapbox_select w-50 m-1">
                                    <input
                                        class="number form-control"
                                        placeholder="calculating.."
                                        id="to_amount"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="rounded shadow p-1 darked">
                                Estimated Gas:
                                <span
                                    class="text-warning"
                                    id="gas_estimate"
                                ></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                disabled
                                class="btn btn-primary w-100"
                                id="swap_button"
                                @click="trySwap"
                            >
                                Connecting
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="token_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select token</h5>
                        <button
                            id="modal_close"
                            @click="closeModal"
                            type="button"
                            class="close btn-close"
                            data-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body modal-swap" id="myDropdown">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search.."
                            id="myInput"
                            @click="filterFunction()"
                            autocomplete="off"
                        />
                        <div
                            id="token_list"
                            style="max-height: 600px; overflow-y: auto"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const serverUrl = "https://t6cacka4pekq.usemoralis.com:2053/server";
const appId = "R8897AYP30KpXaJSrGuvtpqZGo5gUzmCHR0ydxUu";

export default {
    // component list
    components: {},

    // component data
    data() {
        return {
            currentuser: null,
            currentTrade: {},
            currentSelectSide: {},
            tokens: {},
            address: {},
            amount: {},
        };
    },

    // custom methods
    methods: {
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        async init() {
            await Moralis.start({
                serverUrl,
                appId,
            });
            await Moralis.enableWeb3();
            await this.listAvailableTokens();
            this.currentUser = Moralis.User.current();
            if (this.currentUser) {
                document.getElementById("swap_button").disabled = false;
                document.getElementById("swap_button").innerText = "Swap";
            } else {
                document.getElementById("swap_button").innerText =
                    "Connect Wallet First";
            }
        },
        async listAvailableTokens() {
            const result = await Moralis.Plugins.oneInch.getSupportedTokens({
                chain: "eth", // The blockchain you want to use (eth/bsc/polygon)
            });
            let parent = document.getElementById("token_list");

            this.tokens = result.tokens;
            for (const address in this.tokens) {
                let token = this.tokens[address];
                if (token.symbol != "BTC++") {
                    let div = document.createElement("div");
                    div.setAttribute("data-address", address);
                    div.className = "token_row";
                    let html = `
            <a class="dropdown-item" ><img class="token_list_img me-1" height="36px" width="36px" src="../../assets/images/cryptoCurrency/${token.symbol}.png"  loading="lazy">
            <span class="token_list_text">${token.symbol}</span></a>
            `;
                    div.innerHTML = html;
                    div.onclick = () => {
                        this.selectToken(address);
                    };
                    parent.appendChild(div);
                }
            }
        },
        filterFunction() {
            var input, filter, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        },
        selectToken(address) {
            this.closeModal();
            console.log(this.tokens);
            this.currentTrade[this.currentSelectSide] = this.tokens[address];
            this.renderInterface();
            console.log(this.currentTrade);
            this.getQuote();
        },
        renderInterface() {
            if (this.currentTrade.from) {
                document.getElementById("from_token_img").src =
                    this.currentTrade.from.logoURI;
                document
                    .getElementById("from_token_img")
                    .classList.remove("hidden");
                document.getElementById("from_token_text").innerHTML =
                    this.currentTrade.from.symbol;
            }
            if (this.currentTrade.to) {
                document.getElementById("to_token_img").src =
                    this.currentTrade.to.logoURI;
                document
                    .getElementById("to_token_img")
                    .classList.remove("hidden");
                document.getElementById("to_token_text").innerHTML =
                    this.currentTrade.to.symbol;
            }
        },
        openModal(side) {
            this.currentSelectSide = side;
            document.getElementById("token_modal").style.display = "block";
        },
        closeModal() {
            document.getElementById("token_modal").style.display = "none";
        },

        async getQuote() {
            if (
                !this.currentTrade.from ||
                !this.currentTrade.to ||
                !document.getElementById("from_amount").value
            )
                return;

            this.amount = Number(
                document.getElementById("from_amount").value *
                    10 ** this.currentTrade.from.decimals
            );

            const quote = await Moralis.Plugins.oneInch.quote({
                chain: "eth", // The blockchain you want to use (eth/bsc/polygon)
                fromTokenAddress: this.currentTrade.from.address, // The token you want to swap
                toTokenAddress: this.currentTrade.to.address, // The token you want to receive
                amount: amount,
            });
            document.getElementById("gas_estimate").innerHTML =
                quote.estimatedGas;
            document.getElementById("to_amount").value =
                quote.toTokenAmount / 10 ** quote.toToken.decimals;
        },

        async trySwap() {
            this.address = Moralis.User.current().get("ethAddress");
            this.amount = Number(
                document.getElementById("from_amount").value *
                    10 ** this.currentTrade.from.decimals
            );
            if (this.currentTrade.from.symbol !== "ETH") {
                const allowance = await Moralis.Plugins.oneInch.hasAllowance({
                    chain: "eth", // The blockchain you want to use (eth/bsc/polygon)
                    fromTokenAddress: this.currentTrade.from.address, // The token you want to swap
                    fromAddress: this.address, // Your wallet address
                    amount: this.amount,
                });
                console.log(allowance);
                if (!allowance) {
                    await Moralis.Plugins.oneInch.approve({
                        chain: "eth", // The blockchain you want to use (eth/bsc/polygon)
                        tokenAddress: this.currentTrade.from.address, // The token you want to swap
                        fromAddress: this.address, // Your wallet address
                    });
                }
            }
            try {
                let receipt = await this.doSwap(this.address, this.amount);
                notify("success", "Swap Completed Successfully");
            } catch (error) {
                notify("warning", "Swap Failed");
                console.log(error);
            }
        },
        doSwap(userAddress, amount) {
            return Moralis.Plugins.oneInch.swap({
                chain: "eth", // The blockchain you want to use (eth/bsc/polygon)
                fromTokenAddress: this.currentTrade.from.address, // The token you want to swap
                toTokenAddress: this.currentTrade.to.address, // The token you want to receive
                amount: amount,
                fromAddress: userAddress, // Your wallet address
                slippage: 1,
            });
        },
    },

    // on component created
    created() {
        this.init();
    },

    // on component mounted
    mounted() {
        /*const plugin1 = document.createElement("script");
        plugin1.setAttribute(
            "src",
            "https://unpkg.com/moralis/dist/moralis.js"
        );
        plugin1.async = true;
        document.head.appendChild(plugin1);
        const plugin2 = document.createElement("script");
        plugin2.setAttribute(
            "src",
            "https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"
        );
        plugin2.async = true;
        document.head.appendChild(plugin2);*/
    },

    // on component destroyed
    destroyed() {},
};
</script>
