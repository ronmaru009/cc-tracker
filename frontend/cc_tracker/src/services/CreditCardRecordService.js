import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/credit-card-records";

async function createRecord(data) {
  const response = await axios.post(API_URL, data);

  return response.data;
}

async function deleteRecord(id) {
  const response = await axios.delete(`${API_URL}/${id}`);

  return response.data;
}

async function makePayment(recordId, amount) {
  const response = await axios.post(
    `${API_URL}/${recordId}/pay`,

    {
      payment_amount: amount,
    },
  );

  return response.data;
}

export default {
  createRecord,

  deleteRecord,

  makePayment,
};
