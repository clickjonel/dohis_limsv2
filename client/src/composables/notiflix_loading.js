
import { Loading } from 'notiflix';

const useLoader = () => {
  const showLoader = (text = 'Loading Data, Please Wait...') => {
    Loading.dots(text, {
      clickToClose: false,
      fontFamily: 'Lexend Deca',
    });
  };

  const hideLoader = () => {
    Loading.remove(1500);
  };

  return { showLoader, hideLoader };
};

export default useLoader;