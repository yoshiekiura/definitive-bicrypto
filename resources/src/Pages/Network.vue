<template>
    <div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card card-profile">
                    <img
                        src="assets/images/ico/stage-3.jpg"
                        class="card-img-top"
                        alt="Profile Cover Photo"
                    />
                    <div class="card-body">
                        <div class="profile-image-wrapper">
                            <div class="profile-image">
                                <div class="avatar">
                                    <img
                                        class="round"
                                        v-if="user.profile_photo_path != null"
                                        :src="
                                            user.profile_photo_path
                                                ? 'assets/images/profile/' +
                                                  user.profile_photo_path
                                                : '/market/notification.png'
                                        "
                                        :key="user.profile_photo_path"
                                        alt="avatar"
                                    />
                                </div>
                            </div>
                        </div>
                        <h3>{{ user.firstname }}</h3>
                        <h6 class="badge badge-light-success profile-badge">
                            Verified Trader
                        </h6>
                        <span
                            v-if="planA.rank == 0"
                            class="badge badge-light-primary profile-badge"
                            >No Business Rank</span
                        >
                        <span
                            v-else
                            class="badge badge-light-primary profile-badge"
                            >Business Rank {{ planA.rank }}</span
                        >
                        <div
                            class="mt-1"
                            v-if="bvWithdrawable != null"
                            :key="bvWithdrawable"
                        >
                            <div class="d-flex justify-content-between">
                                <small>0 BV</small>
                                <small>{{ planA.bv }} BV</small>
                            </div>
                            <div id="myRangeColor" class="progress">
                                <div
                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    :aria-valuenow="bvWithdrawable"
                                    aria-valuemin="0"
                                    :aria-valuemax="planA.bv"
                                    :style="'width:' + bvWithdrawable + '%'"
                                ></div>
                            </div>
                            <small class="text-warning"
                                >Progress To Unlock Withdrawal</small
                            ><br />
                            <div
                                v-if="bvWithdrawable >= planA.bv"
                                :key="bvWithdrawable"
                            >
                                <button
                                    type="button"
                                    class="btn btn-success mt-1"
                                    :disabled="loading"
                                    @click="Withdraw()"
                                >
                                    Withdraw
                                </button>
                            </div>
                            <div v-else>
                                <button
                                    type="button"
                                    class="btn btn-secondary mt-1"
                                    disabled
                                >
                                    Withdraw Locked
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <Refer
                    v-if="gnl.referal_status == 1"
                    :pathname="pathname"
                    :user="user"
                    :key="gnl.referal_status"
                />
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-10">
                            <h4 class="card-title">All Referrals</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-1">
                            <span
                                v-for="(ref, index) in ref_by"
                                :key="index"
                                class="col me-1 badge bg-warning"
                                >{{ ref.firstname }} {{ ref.lastname }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="row" :key="bvWithdrawable">
                            <div class="col-xl-6 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-primary p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <i
                                                    class="bi bi-briefcase font-medium-5"
                                                ></i>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ bvTotal }} BV
                                        </h2>
                                        <p class="card-text">
                                            Total Business Value
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-warning p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <i
                                                    class="bi bi-diagram-3 font-medium-5"
                                                ></i>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ planA.trade_commission }} BV
                                        </h2>
                                        <p class="card-text">
                                            Network Commission
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-info p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <i
                                                    class="bi bi-node-plus font-medium-5"
                                                ></i>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ planA.ref_commission }} BV
                                        </h2>
                                        <p class="card-text">
                                            Referral Commission
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-success p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <i
                                                    class="bi bi-node-plus-fill font-medium-5"
                                                ></i>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ planA.active_ref_commission }} BV
                                        </h2>
                                        <p class="card-text">
                                            Active Referral Comission
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-transaction">
                            <div class="card-header">
                                <h4 class="card-title">Business Commissions</h4>
                            </div>
                            <div
                                class="card-body"
                                style="max-height: 280px; overflow-y: auto"
                            >
                                <div
                                    v-for="(bvLog, index) in bvLogs"
                                    :key="index"
                                    class="transaction-item"
                                >
                                    <div class="d-flex">
                                        <div
                                            class="avatar bg-light-primary rounded float-start"
                                        >
                                            <div class="avatar-content">
                                                <span
                                                    v-if="bvLog.type == 1"
                                                    class="text-success font-medium-5"
                                                    ><i class="bi bi-cash"></i
                                                ></span>
                                                <span
                                                    v-else-if="bvLog.type == 2"
                                                    class="text-success font-medium-5"
                                                    ><i
                                                        class="bi bi-node-plus"
                                                    ></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 3"
                                                    class="text-success font-medium-5"
                                                    ><i class="bi bi-award"></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 4"
                                                    class="text-success font-medium-5"
                                                    ><i
                                                        class="bi bi-currency-exchange"
                                                    ></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 5"
                                                    class="text-success font-medium-5"
                                                    ><i class="bi bi-robot"></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 6"
                                                    class="text-success font-medium-5"
                                                    ><i class="bi bi-coin"></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 7"
                                                    class="text-success font-medium-5"
                                                    ><i
                                                        class="bi bi-bar-chart"
                                                    ></i
                                                ></span>
                                                <span
                                                    v-if="bvLog.type == 8"
                                                    class="text-success font-medium-5"
                                                    ><i
                                                        class="bi bi-bar-chart"
                                                    ></i
                                                ></span>
                                            </div>
                                        </div>
                                        <div class="transaction-percentage">
                                            <template v-if="bvLog.type == 1">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Referral Deposit
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 2">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Referral First Deposit
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 3">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Active Referral First
                                                    Deposit Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 4">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Trade Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 5">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Bot Investment
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 6">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Token ICO Purchase
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 7">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Forex Deposit
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                            <template v-if="bvLog.type == 8">
                                                <span
                                                    class="text-success fw-bold"
                                                    >Forex Investment
                                                    Commission</span
                                                >
                                                <br />
                                                <small>
                                                    {{
                                                        bvLog.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}
                                                </small>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="fw-bolder">
                                        <span class="badge bg-success"
                                            >+ {{ bvLog.amount }} BV</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Business Network</div>
                                <ul class="tree">
                                    <li>
                                        <span
                                            :class="
                                                mlm.rank == 0
                                                    ? 'text-dark'
                                                    : 'text-success border-success'
                                            "
                                            >{{ user.username }}</span
                                        >
                                        <ul>
                                            <li v-if="mlm.L != null">
                                                <span
                                                    :class="
                                                        mlm.L.rank == 0
                                                            ? 'text-dark'
                                                            : 'text-success border-success'
                                                    "
                                                    >{{ mlm.L.username }}</span
                                                >
                                                <ul>
                                                    <li v-if="mlm.L.L != null">
                                                        <span
                                                            :class="
                                                                mlm.L.L.rank ==
                                                                0
                                                                    ? 'text-dark'
                                                                    : 'text-success border-success'
                                                            "
                                                            >{{
                                                                mlm.L.L.username
                                                            }}</span
                                                        >
                                                        <ul>
                                                            <li
                                                                v-if="
                                                                    mlm.L.L.L !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.L.L
                                                                            .L
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.L.L
                                                                            .L
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .L
                                                                                .L
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .L
                                                                                .L
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>
                                                            <li
                                                                v-if="
                                                                    mlm.L.L.R !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.L.L
                                                                            .R
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.L.L
                                                                            .R
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .L
                                                                                .R
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .L
                                                                                .R
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li v-else>
                                                        <span class="text-dark"
                                                            >No User</span
                                                        >
                                                    </li>

                                                    <li v-if="mlm.L.R != null">
                                                        <span
                                                            :class="
                                                                mlm.L.R.rank ==
                                                                0
                                                                    ? 'text-dark'
                                                                    : 'text-success border-success'
                                                            "
                                                            >{{
                                                                mlm.L.R.username
                                                            }}</span
                                                        >
                                                        <ul>
                                                            <li
                                                                v-if="
                                                                    mlm.L.R.L !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.L.R
                                                                            .L
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.L.R
                                                                            .L
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .R
                                                                                .L
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .R
                                                                                .L
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>

                                                            <li
                                                                v-if="
                                                                    mlm.L.R.R !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.L.R
                                                                            .R
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.L.R
                                                                            .R
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .R
                                                                                .R
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .L
                                                                                .R
                                                                                .R
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li v-else>
                                                <span class="text-dark"
                                                    >No User</span
                                                >
                                            </li>
                                            <li v-if="mlm.R != null">
                                                <span
                                                    :class="
                                                        mlm.R.rank == 0
                                                            ? 'text-dark'
                                                            : 'text-success border-success'
                                                    "
                                                    >{{ mlm.R.username }}</span
                                                >
                                                <ul>
                                                    <li v-if="mlm.R.L != null">
                                                        <span
                                                            :class="
                                                                mlm.R.L.rank ==
                                                                0
                                                                    ? 'text-dark'
                                                                    : 'text-success border-success'
                                                            "
                                                            >{{
                                                                mlm.R.L.username
                                                            }}</span
                                                        >
                                                        <ul>
                                                            <li
                                                                v-if="
                                                                    mlm.R.L.L !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.R.L
                                                                            .L
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.R.L
                                                                            .L
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .L
                                                                                .L
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .L
                                                                                .L
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>

                                                            <li
                                                                v-if="
                                                                    mlm.R.L.R !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.R.L
                                                                            .R
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.R.L
                                                                            .R
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .L
                                                                                .R
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .L
                                                                                .R
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li v-else>
                                                        <span class="text-dark"
                                                            >No User</span
                                                        >
                                                    </li>

                                                    <li v-if="mlm.R.R != null">
                                                        <span
                                                            :class="
                                                                mlm.R.R.rank ==
                                                                0
                                                                    ? 'text-dark'
                                                                    : 'text-success border-success'
                                                            "
                                                            >{{
                                                                mlm.R.R.username
                                                            }}</span
                                                        >
                                                        <ul>
                                                            <li
                                                                v-if="
                                                                    mlm.R.R.L !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.R.R
                                                                            .L
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.R.R
                                                                            .L
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .R
                                                                                .L
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .R
                                                                                .L
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>

                                                            <li
                                                                v-if="
                                                                    mlm.R.R.R !=
                                                                    null
                                                                "
                                                            >
                                                                <span
                                                                    :class="
                                                                        mlm.R.R
                                                                            .R
                                                                            .rank ==
                                                                        0
                                                                            ? 'text-dark'
                                                                            : 'text-success border-success'
                                                                    "
                                                                    >{{
                                                                        mlm.R.R
                                                                            .R
                                                                            .username
                                                                    }}</span
                                                                >
                                                                <ul>
                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .R
                                                                                .R
                                                                                .L !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .L
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .L
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>

                                                                    <li
                                                                        v-if="
                                                                            mlm
                                                                                .R
                                                                                .R
                                                                                .R
                                                                                .R !=
                                                                            null
                                                                        "
                                                                    >
                                                                        <span
                                                                            :class="
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .rank ==
                                                                                0
                                                                                    ? 'text-dark'
                                                                                    : 'text-success border-success'
                                                                            "
                                                                            >{{
                                                                                mlm
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .R
                                                                                    .username
                                                                            }}</span
                                                                        >
                                                                        <ul>
                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .L !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .L
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>

                                                                            <li
                                                                                v-if="
                                                                                    mlm
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .R
                                                                                        .R !=
                                                                                    null
                                                                                "
                                                                            >
                                                                                <span
                                                                                    :class="
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .rank ==
                                                                                        0
                                                                                            ? 'text-dark'
                                                                                            : 'text-success border-success'
                                                                                    "
                                                                                    >{{
                                                                                        mlm
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .R
                                                                                            .username
                                                                                    }}</span
                                                                                >
                                                                            </li>
                                                                            <li
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="text-dark"
                                                                                    >No
                                                                                    User</span
                                                                                >
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li v-else>
                                                                        <span
                                                                            class="text-dark"
                                                                            >No
                                                                            User</span
                                                                        >
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li v-else>
                                                                <span
                                                                    class="text-dark"
                                                                    >No
                                                                    User</span
                                                                >
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li v-else>
                                                        <span class="text-dark"
                                                            >No User</span
                                                        >
                                                    </li>
                                                </ul>
                                            </li>
                                            <li v-else>
                                                <span class="text-dark"
                                                    >No User</span
                                                >
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Refer from "../components/Refer.vue";
export default {
    props: ["user"],
    // component list
    components: {
        Refer,
    },

    // component data
    data() {
        return {
            ref_by: null,
            mlm: {},
            mlmB: {},
            bvTotal: null,
            bvWithdrawable: null,
            bvLogs: null,
            planA: {},
            planB: {},
            pathname:
                window.location.protocol + "//" + window.location.hostname,
            gnl: gnl,
            loading: false,
        };
    },

    // custom methods
    methods: {
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchData() {
            this.$http
                .post("/user/fetch/network")
                .then((response) => {
                    (this.ref_by = response.data.ref_by),
                        (this.mlm = response.data.mlm),
                        (this.mlmB = response.data.mlmB),
                        (this.bvTotal = response.data.bvTotal),
                        (this.bvWithdrawable = response.data.bvWithdrawable),
                        (this.bvLogs = response.data.bvLogs),
                        (this.planA = response.data.planA),
                        (this.planB = response.data.planB);
                })
                .catch((error) => {
                    if (error.response.data.message == "nokyc") {
                        window.location.href = "/user/kyc";
                    }
                });
        },
        Withdraw() {
            (this.loading = true),
                this.$http
                    .post("/user/mlm/withdraw")
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message);
                        this.fetchData();
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        },
    },

    // on component created
    created() {
        this.fetchData();
    },

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
