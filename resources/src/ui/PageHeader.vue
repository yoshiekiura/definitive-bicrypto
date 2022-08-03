<template>
    <div>
        <nav
            v-if="
                configData['mainLayoutType'] === 'horizontal' &&
                configData['mainLayoutType'] !== null
            "
            class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center"
            :class="configData['navbarColor']"
            data-nav="brand-center"
        >
            <div class="navbar-header d-xl-block d-none">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <router-link class="navbar-brand" to="/">
                            <span class="brand-logo">
                                <svg
                                    viewbox="0 0 139 95"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    height="24"
                                >
                                    <defs>
                                        <lineargradient
                                            id="linearGradient-1"
                                            x1="100%"
                                            y1="10.5120544%"
                                            x2="50%"
                                            y2="89.4879456%"
                                        >
                                            <stop
                                                stop-color="#000000"
                                                offset="0%"
                                            ></stop>
                                            <stop
                                                stop-color="#FFFFFF"
                                                offset="100%"
                                            ></stop>
                                        </lineargradient>
                                        <lineargradient
                                            id="linearGradient-2"
                                            x1="64.0437835%"
                                            y1="46.3276743%"
                                            x2="37.373316%"
                                            y2="100%"
                                        >
                                            <stop
                                                stop-color="#EEEEEE"
                                                stop-opacity="0"
                                                offset="0%"
                                            ></stop>
                                            <stop
                                                stop-color="#FFFFFF"
                                                offset="100%"
                                            ></stop>
                                        </lineargradient>
                                    </defs>
                                    <g
                                        id="Page-1"
                                        stroke="none"
                                        stroke-width="1"
                                        fill="none"
                                        fill-rule="evenodd"
                                    >
                                        <g
                                            id="Artboard"
                                            transform="translate(-400.000000, -178.000000)"
                                        >
                                            <g
                                                id="Group"
                                                transform="translate(400.000000, 178.000000)"
                                            >
                                                <path
                                                    class="text-primary"
                                                    id="Path"
                                                    d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                    style="fill: currentColor"
                                                ></path>
                                                <path
                                                    id="Path1"
                                                    d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                    fill="url(#linearGradient-1)"
                                                    opacity="0.2"
                                                ></path>
                                                <polygon
                                                    id="Path-2"
                                                    fill="#000000"
                                                    opacity="0.049999997"
                                                    points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"
                                                ></polygon>
                                                <polygon
                                                    id="Path-21"
                                                    fill="#000000"
                                                    opacity="0.099999994"
                                                    points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"
                                                ></polygon>
                                                <polygon
                                                    id="Path-3"
                                                    fill="url(#linearGradient-2)"
                                                    opacity="0.099999994"
                                                    points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"
                                                ></polygon>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <h2 class="brand-text mb-0"></h2>
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
        <nav
            v-else
            :class="[
                'header-navbar navbar navbar-expand-lg align-items-center ' +
                    configData['navbarClass'] +
                    ' navbar-light navbar-shadow' +
                    ' ' +
                    configData['navbarColor'] +
                    ' ',
                configData['layoutWidth'] === 'boxed' &&
                configData['verticalMenuNavbarType'] === 'navbar-floating'
                    ? 'container-xxl'
                    : '',
            ]"
        >
            <div class="navbar-container d-flex content">
                <div class="bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav d-xl-none">
                        <li class="nav-item">
                            <a
                                class="nav-link menu-toggle"
                                href="javascript:void(0);"
                                @click="addOverlay()"
                                ><i class="bi bi-list font-medium-5"></i
                            ></a>
                        </li>
                    </ul>
                </div>

                <ul class="nav navbar-nav align-items-center ms-auto">
                    <li
                        v-if="user !== null && user.role_id == 1"
                        class="nav-item me-1 d-none d-sm-contents"
                    >
                        <a href="admin/dashboard"
                            ><button class="btn btn-secondary">
                                Admin Dashboard
                            </button></a
                        >
                    </li>
                    <li
                        class="nav-item dropdown"
                        v-if="user !== null"
                        :key="user.eth_Address"
                    >
                        <button
                            v-if="ext !== null && ext.walletConnect == 1"
                            type="button"
                            class="btn btn-icon mx-1 d-flex"
                            :class="
                                user.eth_Address == null
                                    ? 'btn-outline-secondary text-secondary'
                                    : 'btn-outline-success text-success'
                            "
                            data-bs-toggle="collapse"
                            data-bs-target="#WalletModal"
                        >
                            <span v-if="user.eth_Address == null">
                                <i
                                    class="bi bi-wallet"
                                    style="margin-right: 5px"
                                >
                                </i>
                                <span class="d-none d-sm-contents">
                                    Connect Wallet</span
                                ></span
                            >
                            <span v-else>
                                <i
                                    class="bi bi-wallet2"
                                    style="margin-right: 5px"
                                >
                                </i>
                                <span class="d-none d-sm-contents">
                                    Connected</span
                                ></span
                            >
                        </button>
                        <button
                            v-else
                            type="button"
                            class="btn btn-icon btn-outline-success text-success mx-1 d-flex"
                            data-bs-toggle="collapse"
                            data-bs-target="#WalletModal"
                        >
                            <span
                                class="d-none d-sm-contents"
                                style="margin-right: 5px"
                            >
                                <i
                                    class="bi bi-wallet2"
                                    style="margin-right: 5px"
                                ></i
                                ><span class="d-none d-sm-contents">
                                    My Wallets</span
                                ></span
                            >
                        </button>
                    </li>
                    <li class="nav-item dropdown dropdown-user">
                        <a
                            class="nav-link dropdown-toggle dropdown-user-link"
                            id="dropdown-user"
                            href="javascript:void(0);"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                        >
                            <div class="user-nav d-md-flex d-none">
                                <span class="user-name fw-bolder">
                                    <span v-if="user !== null">{{
                                        user.name
                                    }}</span
                                    ><span v-else>John Doe</span>
                                </span>
                                <span class="user-status" v-if="user !== null">
                                    <span v-if="user.role_id == 1">Admin</span
                                    ><span v-else>{{ user.id }}</span>
                                </span>
                            </div>
                            <span class="avatar">
                                <img
                                    v-if="user !== null"
                                    class="round"
                                    :src="
                                        user.profile_photo_path
                                            ? '/assets/images/profile/' +
                                              user.profile_photo_path
                                            : '/market/notification.png'
                                    "
                                    alt="avatar"
                                    height="40"
                                    width="40"
                                />
                                <span class="avatar-status-online"></span>
                            </span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="dropdown-user"
                        >
                            <h6 class="dropdown-header">Manage Profile</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/user/profile">
                                <i class="bi bi-person-circle me-50"></i>
                                Profile
                            </a>
                            <a
                                class="dropdown-item"
                                href="/user/support/ticket"
                            >
                                <i class="bi bi-person-circle me-50"></i>
                                Support
                            </a>
                            <a
                                v-if="user !== null"
                                class="dropdown-item"
                                @click="user_logout()"
                            >
                                <i class="bi bi-box-arrow-in-left me-50"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div
            id="WalletModal"
            class="collapse position-absolute sticky-top end-0"
            style="top: 65px"
        >
            <div class="card" style="box-shadow: 0 4px 24px 0 rgb(0 0 0 / 30%)">
                <div class="card-body">
                    <div class="row" style="margin: 0 0">
                        <div class="col-lg-12 col-md-12">
                            <div
                                class="row p-1 rounded shadow"
                                :class="
                                    $route.path == '/wallets/funding/*'
                                        ? 'bg-wallet-active'
                                        : 'bg-wallet'
                                "
                            >
                                <a style="display: contents">
                                    <div class="col-6 test-start">
                                        <div class="fs-bold fs-4 text-dark">
                                            Funding Wallet
                                        </div>
                                    </div>
                                    <div
                                        class="col-6 text-end"
                                        v-if="wal !== null"
                                    >
                                        <router-link
                                            v-if="wal.funding !== null"
                                            to="/wallets"
                                            ><button
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="bi bi-plus"></i
                                                >Deposit
                                            </button></router-link
                                        >
                                        <router-link v-else to="/wallets">
                                            <button
                                                type="submit"
                                                class="mt-1 btn btn-primary btn-sm"
                                            >
                                                Create Wallet
                                            </button>
                                        </router-link>
                                    </div>
                                </a>
                            </div>
                            <div
                                class="row p-1 rounded shadow mt-1"
                                :class="
                                    $route.path == '/wallets/trading/*'
                                        ? 'bg-wallet-active'
                                        : 'bg-wallet'
                                "
                            >
                                <a style="display: contents">
                                    <div class="col-6 test-start">
                                        <div class="fs-bold fs-4 text-dark">
                                            Trading Wallet
                                        </div>
                                    </div>
                                    <div
                                        class="col-6 text-end"
                                        v-if="wal !== null"
                                    >
                                        <router-link
                                            v-if="wal.trading !== null"
                                            to="/wallets"
                                            ><button
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="bi bi-plus"></i
                                                >Deposit
                                            </button></router-link
                                        >
                                        <router-link v-else to="/wallets">
                                            <button
                                                type="submit"
                                                class="mt-1 btn btn-primary btn-sm"
                                            >
                                                Create Wallet
                                            </button>
                                        </router-link>
                                    </div>
                                </a>
                            </div>
                            <div
                                v-if="
                                    ext !== null &&
                                    ext.walletConnect == 1 &&
                                    user !== null
                                "
                                class="row bg-wallet shadow p-1 rounded mt-1"
                            >
                                <div style="display: contents">
                                    <a
                                        class="col-6 test-start"
                                        data-bs-toggle="modal"
                                        data-bs-target="#walletConnect"
                                    >
                                        <div class="fs-bold fs-4 text-dark">
                                            Personal Wallet
                                        </div>
                                        <small
                                            class="fs-bold text-success walletConnectBtc"
                                            >{{
                                                user.eth_Address !== null
                                                    ? truncate(
                                                          user.eth_Address,
                                                          25
                                                      )
                                                    : "No Wallet Connected"
                                            }}</small
                                        >
                                    </a>
                                    <div class="col-6 text-end">
                                        <button
                                            v-if="user.eth_Address !== null"
                                            @click="logOut()"
                                            class="btn-logout btn btn-sm mt-1 me-1 btn-danger"
                                        >
                                            Disconnect
                                        </button>
                                        <button
                                            v-else
                                            class="btn btn-sm mt-1 me-1 btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#walletConnect"
                                        >
                                            Connect
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="ext !== null && ext.walletConnect == 1"
            class="modal fade"
            tabindex="-1"
            id="walletConnect"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wallet Connect</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div
                            style="
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                            "
                        >
                            <div
                                @click="login('Metamask')"
                                style="
                                    align-items: center;
                                    display: flex;
                                    flex-direction: column;
                                    height: auto;
                                    justify-content: center;
                                    margin-left: auto;
                                    margin-right: auto;
                                    padding: 20px 5px;
                                    cursor: pointer;
                                "
                            >
                                <img
                                    src="/assets/images/wallets/metamaskWallet.png"
                                    alt="Metamask"
                                    style="
                                        align-self: center;
                                        fill: rgb(40, 13, 95);
                                        flex-shrink: 0;
                                        margin-bottom: 8px;
                                        height: 30px;
                                    "
                                /><span
                                    class="ant-typography"
                                    style="font-size: 14px"
                                    >Metamask</span
                                >
                            </div>
                            <div
                                @click="login('WalletConnect')"
                                style="
                                    align-items: center;
                                    display: flex;
                                    flex-direction: column;
                                    height: auto;
                                    justify-content: center;
                                    margin-left: auto;
                                    margin-right: auto;
                                    padding: 20px 5px;
                                    cursor: pointer;
                                "
                            >
                                <img
                                    src="/assets/images/wallets/wallet-connect.svg"
                                    alt="WalletConnect"
                                    style="
                                        align-self: center;
                                        fill: rgb(40, 13, 95);
                                        flex-shrink: 0;
                                        margin-bottom: 8px;
                                        height: 30px;
                                    "
                                /><span
                                    class="ant-typography"
                                    style="font-size: 14px"
                                    >WalletConnect</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["configData"],
    components: {},
    setup() {},
    // component data
    data() {
        return {
            siteName: siteName,
            user: null,
            ext: ext,
            wal: null,
        };
    },
    methods: {
        addOverlay() {
            $("body")
                .addClass("vertical-overlay-menu")
                .removeClass("vertical-menu-modern");
        },
        fetchData() {
            this.$http.post("/user/fetch/data").then((response) => {
                (this.user = response.data.user),
                    (this.wal = response.data.wal);
            });
        },
        user_logout() {
            this.$http
                .post("/logout")
                .then((response) => {
                    this.$toast.success("Logged Out Successfully");
                    location.reload();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async login($a) {
            let client = Moralis.User.current();
            if (!client) {
                if ($a == "Metamask") {
                    client = await Moralis.authenticate({
                        signingMessage:
                            "Log to " + this.siteName + " using MetaMask",
                    })
                        .then((client) => {
                            let ethAddress = client.get("ethAddress");
                            this.$http
                                .post("/user/wallet/connect", {
                                    ethAddress: ethAddress,
                                })
                                .then((response) => {
                                    $("#walletConnect").modal("hide");
                                    if (response.data == 1) {
                                        this.$toast.success(
                                            "Wallet Connected Successfully"
                                        );
                                    } else {
                                        this.$toast.error(
                                            "Wallet Connection Failed"
                                        );
                                    }
                                    this.fetchData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else if ($a == "WalletConnect") {
                    client = await Moralis.authenticate({
                        provider: "walletconnect",
                    })
                        .then((client) => {
                            let ethAddress = client.get("ethAddress");
                            this.$http
                                .post("/user/wallet/connect", {
                                    ethAddress: ethAddress,
                                })
                                .then((response) => {
                                    $("#walletConnect").modal("hide");
                                    if (response.data == 1) {
                                        this.$toast.success(
                                            "Wallet Connected Successfully"
                                        );
                                    } else {
                                        this.$toast.error(
                                            "Wallet Connection Failed"
                                        );
                                    }
                                    this.fetchData();
                                })
                                .catch((error) => {
                                    console.log(error);
                                })
                                .finally(() => {});
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            } else {
                let ethAddress = client.get("ethAddress");
                this.$http
                    .post("/user/wallet/connect", {
                        ethAddress: ethAddress,
                    })
                    .then((response) => {
                        $("#walletConnect").modal("hide");
                        if (response.data == 1) {
                            this.$toast.success(
                                "Wallet Connected Successfully"
                            );
                        } else {
                            this.$toast.error("Wallet Connection Failed");
                        }
                        this.fetchData();
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {});
            }
        },
        async logOut() {
            await Moralis.User.logOut();
            this.$http
                .post("/user/wallet/disconnect")
                .then((response) => {
                    $("#walletConnect").modal("hide");
                    if (response.data == 1) {
                        this.$toast.success("Wallet Disconnected Successfully");
                    } else {
                        this.$toast.error("Wallet Disconnection Failed");
                    }
                    this.fetchData();
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {});
        },
        truncate(str, n) {
            return str.length > n ? str.substr(0, n - 1) + "&hellip;" : str;
        },
    },
    created() {
        this.fetchData();
        Moralis.start({
            serverUrl,
            appId,
        });
    },
};
</script>
