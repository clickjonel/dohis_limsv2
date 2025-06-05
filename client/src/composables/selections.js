import useApi from "./api_calls"; 

const { fetchRequest } = useApi();

const useSelection = () => {

  const userSelection = async (options) => {
    var response = await fetchRequest('user/selection',options)
    response.toast()
    
    if(response.apiResponseStatus === 200 && response.data.users){
        // console.log(response.data.users)
        return response.data.users;
    }

  };

  const categorySelection = async (options) => {
    var response = await fetchRequest('categories/selection',options)
    response.toast()
    
    if(response.apiResponseStatus === 200 && response.data.categories){
        // console.log(response.data.users)
        return response.data.categories;
    }

  };

  return { userSelection,categorySelection };
};

export default useSelection;