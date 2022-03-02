<template>
    <section class="section py-4">
        <div class="grid-container mt-6">
            <div class="grid-container grid-container--small text-center">
                <h1 class="text-54 weight-100 text-darkGreen">
                    Great! One more step before we get started.
                </h1>

                <p class="font-book text-25 px-5">
                    Looks like you may be eligible to have your fee waived. In
                    order to confirm, please upload proof of income, such as a
                    pay stub or tax form. Remember, if you have any questions,
                    you can always click on IRIS below to speak to a financial
                    counselor!
                </p>
            </div>

            <table class="mt-5">
                <tr>
                    <th>Filename</th>
                    <th>Date Uploaded</th>
                </tr>
                <tr v-for="file in files" :key="file.id" class="text-center">
                    <td>{{ file.original_filename }}</td>
                    <td>
                        {{
                            file.created_at
                                | dateParse("YYYY-MM-DD")
                                | dateFormat("MMMM D, YYYY")
                        }}
                    </td>
                </tr>
            </table>

            <div class="lds-ring-container" v-if="uploadInProgress">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

            <form
                v-if="!uploadInProgress"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 grid-x grid-margin-x align-center"
                enctype="multipart/form-data"
            >
                <div
                    class="form__fieldWrapper display-flex flex-wrap cell small-12 my-6"
                >
                    <input
                        name="files"
                        placeholder="Upload Files"
                        type="file"
                        id="files"
                        ref="files"
                        @change="handleFile($event)"
                        class="form__input form__input--upload visuallyhidden"
                        multiple
                    />

                    <label
                        class="form__label form__label--upload display-block flex-center text-20 weight-500 lh-1 text-darkGray file-upload-input"
                        for="files"
                        ><img
                            svg-inline
                            src="@img/svg/upload.svg"
                            class="mr-2"
                        />
                        Upload Files</label
                    >
                </div>

                <div class="form__fieldWrapper cell small-12 mt-6">
                    <div class="grid-x grid-margin-x align-center">
                        <div class="cell shrink">
                            <button
                                value="submit"
                                name="submit"
                                type="submit"
                                class="button button--stepNav"
                            >
                                Continue
                            </button>
                        </div>

                        <div class="cell small-12 flex-center mt-5">
                            <back-button></back-button>
                        </div>
                    </div>
                </div>
            </form>
            <div
                v-if="message"
                class="alert text-error text-center my-3 weight-500 text-20"
            >
                {{ message }}
            </div>
        </div>
    </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "BankruptcyUnderThreshold",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            temp_files: [],
            uploadInProgress: false
        };
    },
    computed: {
        ...mapGetters({
            file: "files/file",
            files: "files/files"
        })
    },
    methods: {
        onSubmit($event) {
            this.saving = true;
            this.message = false;

            if (
                this.files &&
                this.files.length > 0 &&
                this.temp_files.length === 0
            ) {
                this.$store.dispatch("steps/completeStep", {
                    name: this.$route.name,
                    steps: this.steps
                });

                // Disable the over threshold step since this was already completed
                this.$store.dispatch("steps/disableSteps", {
                    steps: this.steps,
                    names: ["BankruptcyOverThreshold"]
                });

                this.$store.dispatch("steps/goToNextStep", {
                    next_step: this.next_step
                });
            } else {
                this.message = "Please upload a file.";
            }
            /*
            if (this.temp_files && this.temp_files.length > 0) {
                for (let i = 0; i < this.temp_files.length; i++) {
                    let formData = new FormData();
                    formData.append("file", this.temp_files[i]);
                    formData.append("submission_id", this.submission.id);
                    formData.append("filename", this.temp_files[i].name);

                    axios
                        .post("/api/files", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            }
                        })
                        .then(response => {
                            // Last file has been uploaded
                            if (i === this.temp_files.length - 1) {
                                this.$store.dispatch("files/getFiles");

                                this.$store.dispatch("steps/completeStep", {
                                    name: this.$route.name,
                                    steps: this.steps
                                });

                                // Disable the over threshold step since this was already completed
                                this.$store.dispatch("steps/disableSteps", {
                                    steps: this.steps,
                                    names: ["BankruptcyOverThreshold"]
                                });

                                this.$store.dispatch("steps/goToNextStep", {
                                    next_step: this.next_step
                                });
                            }
                        })
                        .catch(function() {
                            console.log(
                                "Unable to upload file, invalid file type."
                            );
                        });
                }
            }
            */
        },
        handleFile($event) {
            let justUploaded = Array.from(this.$refs.files.files);
            // Append to array of other (if any) files uploaded in this view
            //this.temp_files = this.temp_files.concat(justUploaded);
            let formData = new FormData();
            formData.append("file", justUploaded[0]);
            formData.append("submission_id", this.submission.id);
            formData.append("filename", justUploaded[0].name);

            if (parseInt(justUploaded[0].size) / 1048576 > 16) {
                this.message = "File size must be < 16MB";
                return;
            }
            this.uploadInProgress = true;

            axios
                .post("/api/files", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Authorization: "Bearer " + localStorage.getItem("jwt")
                    }
                })
                .then(response => {
                    this.uploadInProgress = false;
                    this.$store.dispatch("files/getFiles");
                })
                .catch(error => {
                    console.log(error.response);
                    this.uploadInProgress = false;
                    if (error.response.data.errors)
                        this.message = error.response.data.errors.file[0];
                    else
                        this.message = error.response.data.message;
                });
        },
        goToOverThreshold() {
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                names: ["BankruptcyUnderThreshold"]
            });

            this.$store.dispatch("steps/enableSteps", {
                steps: this.steps,
                names: ["BankruptcyOverThreshold"]
            });

            this.$store.dispatch("steps/goToStep", "BankruptcyOverThreshold");
        }
    },
    mounted() {
        this.$store.dispatch("files/getFiles");
    }
};
</script>

<style>
.lds-ring-container {
    display: flex;
    justify-content: center;
    margin: 4rem auto;
}
.lds-ring {
    display: inline-block;
    position: relative;
    width: 64px;
    height: 64px;
}
.lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 25px;
    height: 25px;
    border: 3px solid #008752;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #008752 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
}
@keyframes lds-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
