// const SUBMISSIONS_UPDATED = (state, submissions) => {
//   state.submissions = submissions;
// };

const SUBMISSION_CREATED = (state, submission) => {
    if (submission.data) {
        state.submission = submission.data;
    } else {
        state.submission = submission;
    }
};

const SUBMISSION_UPDATED = (state, submission) => {
    if (submission.data) {
        state.submission = submission.data;
    } else {
        state.submission = submission;
    }
    localStorage.setItem("submission-reason", submission.reason);
};

const SUBMISSION_REASONS_UPDATED = (state, submission_reasons) => {
    state.submission_reasons = submission_reasons;
};

const SUBMISSION_REASON_UPDATED = (state, submission_reason) => {
    state.submission.reason = submission_reason;
};

const SUBMISSION_TYPE_UPDATED = (state, submission_type) => {
    state.submission.submission_type = submission_type;
};

const SUBMISSION_BANKRUPTCY_DISCLOSURE_UPDATED = (state, disclosure) => {
    state.submission_bankruptcy_disclosure = disclosure;
};

const SUBMISSION_BANKRUPTCY_TIME_REMAINING_UPDATED = (state, time) => {
    state.submission.bankruptcy_session_time = time;
};

const RESET_SUBMISSION = state => {
    state.submission.id = 0;
    state.submission.user_id = 0;
    state.submission.submission_type = null;
    state.submission.reason = null;
    state.submission.first_name = null;
    state.submission.last_name = null;
    state.submission.address_line_1 = null;
    state.submission.address_line_2 = null;
    state.submission.city = null;
    state.submission.state = null;
    state.submission.zip = null;
    state.submission.phone = null;
    state.submission.income_dependents = 0;
    state.submission.gross_employment_income = 0;
    state.submission.net_employment_income = 0;
    state.submission.self_employment_income = 0;
    state.submission.benefits_income = 0;
    state.submission.retirement_income = 0;
    state.submission.social_security_income = 0;
    state.submission.pension_income = 0;
    state.submission.other_income = 0;
    state.submission.ssn = null;
    state.submission.co_applicant_first_name = null;
    state.submission.co_applicant_last_name = null;
    state.submission.co_applicant_email = null;
    state.submission.co_applicant_ssn = null;
    state.submission.co_applicant_address_line_1 = null;
    state.submission.co_applicant_address_line_2 = null;
    state.submission.co_applicant_city = null;
    state.submission.co_applicant_state = null;
    state.submission.co_applicant_zip = null;
    state.submission.bankruptcy_session_time = 0;
    state.submission.credit_approval = false;
    state.submission.counseling_approval = false;
    state.submission.bankruptcy_approval = false;
    state.submission.accept_bankruptcy_disclosure = false;
    state.submission.military = false;
    state.submission.accept_statement_of_counseling = false;
    state.submission.message = null;
    state.submission.ip_address = null;
    state.submission.selected_incomes = null;
    state.submission.selected_expenses = null;
    state.submission.last_saved_step = null;
    state.submission.steps_namespace = null;
    state.submission.credit_pull = false;
    state.submission.joint_coapplicant = false;
    state.submission.referrer = null;
    state.submission.referrer_tag_id = null;
    state.submission.date_of_birth = null;
    state.submission.co_applicant_date_of_birth = null;
};


export default {
    SUBMISSION_CREATED,
    SUBMISSION_UPDATED,
    SUBMISSION_REASONS_UPDATED,
    SUBMISSION_REASON_UPDATED,
    SUBMISSION_TYPE_UPDATED,
    SUBMISSION_BANKRUPTCY_DISCLOSURE_UPDATED,
    SUBMISSION_BANKRUPTCY_TIME_REMAINING_UPDATED,
    RESET_SUBMISSION
};
