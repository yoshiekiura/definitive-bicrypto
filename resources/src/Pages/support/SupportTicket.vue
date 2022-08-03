<template>
    <div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card" v-if="my_ticket != null">
                    <div class="card-body">
                        <div class="card-header">
                            <h5 class="title">
                                <span
                                    v-if="my_ticket.status == 0"
                                    class="badge bg-success"
                                    >Open</span
                                >
                                <span
                                    v-else-if="my_ticket.status == 1"
                                    class="badge bg-primary"
                                    >Answered</span
                                >
                                <span
                                    v-else-if="my_ticket.status == 2"
                                    class="badge bg-warning"
                                    >Replied</span
                                >
                                <span
                                    v-else-if="my_ticket.status == 3"
                                    class="badge bg-danger"
                                    >Closed</span
                                >
                                <span v-else class="text-white"
                                    >[Ticket#{{ my_ticket.ticket }}]
                                    {{ my_ticket.subject }}</span
                                >
                            </h5>
                            <a
                                href="javascript:void(0)"
                                data-bs-toggle="modal"
                                data-bs-target="#DelModal"
                                class="btn-sm d-block btn btn-primary btn-danger text-center mt-2"
                                >Close Ticket</a
                            >
                        </div>
                        <div class="card-body">
                            <form
                                v-if="my_ticket.status != 4"
                                @submit.prevent="reply(my_ticket.id)"
                                class="message__chatbox__form row"
                            >
                                <div class="form-group col-sm-12">
                                    <textarea
                                        id="message"
                                        v-model="message"
                                        class="form-control"
                                        placeholder="Enter Message"
                                    ></textarea>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="d-flex mt-1">
                                        <div class="start-group col p-0">
                                            <label for="file" class="label"
                                                >Attachments</label
                                            >
                                            <input
                                                type="file"
                                                class="overflow-hidden form-control mb-2"
                                                id="file"
                                                ref="file"
                                                @change="handleFileUpload()"
                                            />
                                            <div
                                                id="fileUploadsContainer"
                                            ></div>
                                            <span class="info fs-14"
                                                >Allowed File Extensions: .jpg,
                                                .jpeg, .png, .pdf, .doc,
                                                .docx</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 mt-2 mb-0">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        name="replayTicket"
                                        value="1"
                                    >
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="reply-message-area" v-if="messages != null">
                            <div
                                v-for="(message, index) in messages"
                                :key="index"
                            >
                                <div
                                    v-if="message.admin_id == 0"
                                    class="reply-item rounded bg-wallet mb-1 p-1 shadow border-light"
                                >
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="reply-thumb">
                                                <img
                                                    :src="
                                                        '/assets/images/profile/' +
                                                        user.profile_photo_path
                                                    "
                                                    alt="User"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="meta-date text-warning">
                                                Posted on
                                                <span class="cl-theme">{{
                                                    message.created_at
                                                        | moment(
                                                            "dddd, MMMM Do YYYY"
                                                        )
                                                }}</span>
                                            </div>
                                            <p
                                                v-html="ren(message.message)"
                                            ></p>
                                            <div
                                                v-if="message.attachments > 0"
                                                class="mt-2"
                                            >
                                                <a
                                                    v-for="(
                                                        image, key, index
                                                    ) in message.attachments"
                                                    :key="index"
                                                    :href="
                                                        'ticket/download/' +
                                                        image.id
                                                    "
                                                    class="mr-3"
                                                    ><i
                                                        class="bi bi-file-earmark"
                                                    ></i>
                                                    Attachment
                                                    {{ key++ }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="name-area">
                                        <h6 class="title">
                                            {{ message.ticket }}
                                        </h6>
                                    </div>
                                </div>
                                <ul v-else>
                                    <li>
                                        <div class="reply-item">
                                            <div class="name-area">
                                                <div class="reply-thumb">
                                                    <img
                                                        :src="
                                                            '/assets/images/profile/' +
                                                            admin.profile_photo_path
                                                        "
                                                        height="400"
                                                        width="400"
                                                        alt="Admin Image"
                                                    />
                                                </div>
                                                <h6 class="title">
                                                    {{ admin.name }}
                                                </h6>
                                            </div>
                                            <div class="content-area">
                                                <span class="meta-date">
                                                    Posted on,
                                                    <span class="cl-theme">{{
                                                        message.created_at
                                                            | moment(
                                                                "dddd, MMMM Do YYYY"
                                                            )
                                                    }}</span>
                                                </span>
                                                <p
                                                    v-html="
                                                        ren(message.message)
                                                    "
                                                ></p>
                                                <div
                                                    v-if="attachments != null"
                                                    class="mt-2"
                                                >
                                                    <a
                                                        v-for="(
                                                            image, key, index
                                                        ) in attachments"
                                                        :key="index"
                                                        :href="
                                                            'ticket/download/' +
                                                            image.id
                                                        "
                                                        class="mr-3"
                                                        ><i
                                                            class="bi bi-file-earmark"
                                                        ></i
                                                        >Attachment
                                                        {{ key++ }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade custom-modal" id="DelModal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Confirmation</h6>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        class="deposit-form"
                        @submit.prevent="confirm(my_ticket.id)"
                    >
                        @csrf
                        <div class="modal-body">
                            <p>
                                Are you sure you want to close this support
                                ticket
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm text-white btn-danger"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary btn-sm text-white btn-success"
                                name="replayTicket"
                                value="2"
                            >
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],
    // component list
    components: {},

    // component data
    data() {
        return {
            my_ticket: [],
            messages: [],
            message: "",
            attachments: [],
            file: "",
            admin: [],
        };
    },

    // custom methods
    methods: {
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchData() {
            this.$http
                .post("/user/fetch/support/ticket", {
                    ticket: this.$route.params.ticket,
                })
                .then((response) => {
                    (this.my_ticket = response.data.my_ticket),
                        (this.attachments = response.data.attachments),
                        (this.admin = response.data.admin),
                        (this.messages = response.data.messages);
                    console.log(this.messages);
                });
        },
        reply(id) {
            this.$http
                .post("/reply/" + this.$route.params.ticket, {
                    message: this.message,
                    attachments: this.file,
                })
                .then((response) => {
                    console.log(response);
                });
        },
        ren(message) {
            return `${message}`;
        },
        extraTicketAttachment() {},
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
