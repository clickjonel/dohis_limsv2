import { Loading,Confirm,Block,Notify,Report } from 'notiflix';

const notifyOptions = {
    fontFamily:'Lexend Deca',
    timeout:1000
}

const reportOptions = {
    fontFamily:'Lexend Deca',
}

// Notiflix Loader
export const showLoader = (text) => {
  Loading.dots(text, {
    clickToClose: false,
    fontFamily: 'Lexend Deca',
  });
};

export const hideLoader = () => {
  Loading.remove(1500);
};

// Notiflix Notify
export const showToast = (type, text) => {
  Notify[type](text, notifyOptions);
};


// Notiflix Report
export const showReport = (type, title,message,buttonText,callback_function) => {
  Report[type](
    title,
    message,
    buttonText,
    () => {
      callback_function()
    },
    reportOptions
  );
};


