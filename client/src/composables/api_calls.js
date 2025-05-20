import axiosInstance from "../axios/axios";
import { showLoader,hideLoader, showToast } from "./notiflix";

const useApi = () => {
  const fetchRequest = async (url, params = {}) => {
    showLoader('Please Wait...');

    try {
      const response = await axiosInstance.get(url, { params });
          return {
            data:response.data,
            toast: () => {
                showToast('success','Data Fetched Successfuly')
            }
        }
    } 
    catch (error) {
        return {
            error:error.response.data,
            toast: () => {
                showToast('failure',error.response.data.message)
            }
        }
       
    } 
    finally {
      hideLoader();
    }
  };

  return { fetchRequest };
};

export default useApi;

