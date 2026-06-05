import api from "./api";

async function createRecord(data) {
  const response = await api.post("/credit-card-records", data);

  return response.data;
}

async function deleteRecord(id) {
  const response = await api.delete(`/credit-card-records/${id}`);

  return response.data;
}

async function makePayment(recordId, amount) {
  const response = await api.post(
    `/credit-card-records/${recordId}/pay`,

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
