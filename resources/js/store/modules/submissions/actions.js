import api from "@/api";
import store from "@/store";
import { steps } from "@/steps";

const getSubmission = async context => {
    await api.getUrl(context, "/api/submission", "SUBMISSION_UPDATED");
};

const createSubmission = (context, payload) => {
    api.postUrl(context, "/api/submissions", payload, "SUBMISSION_CREATED");
};

const updateSubmissionType = (context, payload) => {
    window.localStorage.setItem("submission-type", payload);
    context.commit("SUBMISSION_TYPE_UPDATED", payload);
};

const updateSubmissionReason = (context, payload) => {
    context.commit("SUBMISSION_REASON_UPDATED", payload);
};

const updateBankruptcyDisclosure = (context, payload) => {
    context.commit("SUBMISSION_BANKRUPTCY_DISCLOSURE_UPDATED", payload);
};

const updateSubmission = async (context, payload) => {
    return await api.patchUrl(
        context,
        "/api/submissions/" + payload.id,
        payload,
        "SUBMISSION_UPDATED"
    );
};

const getSubmissionReasons = context => {
    api.getUrl(
        context,
        "/api/submission-reasons",
        "SUBMISSION_REASONS_UPDATED"
    );
};

const resetSubmission = context => {
    context.commit("RESET_SUBMISSION");
};

export default {
    getSubmission,
    createSubmission,
    updateSubmission,
    getSubmissionReasons,
    updateSubmissionType,
    updateSubmissionReason,
    updateBankruptcyDisclosure,
    resetSubmission
};
