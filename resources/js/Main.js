import React from 'react'
import OldResultList from "./Components/OldResultList";
import Loader from "./Loader";
import Cookies from 'universal-cookie';
import Company from "./Components/Company";
import {useForm} from "react-hook-form";


function Main() {

    const [result, setResult] = React.useState(false);
    const [failedSearch, setFailedSearch] = React.useState(false);
    const [oldResult, setOldResult] = React.useState([]);
    const [loading, setLoading] = React.useState(false);
    const app_url = process.env.MIX_APP_URL == null ? 'http://restapireact' : process.env.MIX_APP_URL;
    const cookies = new Cookies();


    function setResultToCookie(data) {
        let data_array;
        if (cookies.get('old_result_data')) {
            data_array = cookies.get('old_result_data');
            data_array.unshift({
                company_name: data.company_name,
                company_kpp: data.company_kpp,
                company_inn: data.company_inn,
                company_address: data.company_address
            });
            data_array = data_array.slice(0, 5);
        } else {
            //first
            data_array = [
                {
                    company_name: data.company_name,
                    company_kpp: data.company_kpp,
                    company_inn: data.company_inn,
                    company_address: data.company_address
                }
            ];
        }
        let date_time = new Date();
        date_time.setTime(date_time.getTime() + (24 * 60 * 60 * 1000));//one day
        cookies.set('old_result_data', data_array, {path: '/', expires: date_time});
        setOldResult(data_array);
    }


    const {register, handleSubmit, errors} = useForm(); // инициализация хука
    const onSubmit = (data, e) => {

        setLoading(true);
        fetch(app_url + '/api/companies?inn=' + data.inn_input.trim())
            .then(response => {
                if (!response.ok) {
                    throw Error(response.statusText);
                }
                return response.json();
            })
            .then(response_data => {

                setLoading(false);

                if (response_data.status === false) {
                    setFailedSearch({'inn': data.inn_input.trim()});
                    setResult(false);
                } else {
                    //Set old result to cookie
                    setResultToCookie(response_data.info);

                    setResult(
                        {
                            company_name: response_data.info.company_name,
                            company_kpp: response_data.info.company_kpp,
                            company_inn: response_data.info.company_inn,
                            company_address: response_data.info.company_address
                        }
                    );
                    setFailedSearch(false);
                }

            })
            .catch(function () {
                setLoading(false);
                setFailedSearch({'inn': data.inn_input.trim()});
                setResult(false);
            });

        e.target.reset();
    };

    const innValidate = (score) => {

        if (score.match(/\D/)) {
            return false;
        }

        let inn = score.match(/(\d)/g);


        if (inn.length === 10) {
            return inn[9] === String(((
                2 * inn[0] + 4 * inn[1] + 10 * inn[2] +
                3 * inn[3] + 5 * inn[4] + 9 * inn[5] +
                4 * inn[6] + 6 * inn[7] + 8 * inn[8]
            ) % 11) % 10);
        } else if (inn.length === 12) {
            return inn[10] === String(((
                7 * inn[0] + 2 * inn[1] + 4 * inn[2] +
                10 * inn[3] + 3 * inn[4] + 5 * inn[5] +
                9 * inn[6] + 4 * inn[7] + 6 * inn[8] +
                8 * inn[9]
            ) % 11) % 10) && inn[11] === String(((
                3 * inn[0] + 7 * inn[1] + 2 * inn[2] +
                4 * inn[3] + 10 * inn[4] + 3 * inn[5] +
                5 * inn[6] + 9 * inn[7] + 4 * inn[8] +
                6 * inn[9] + 8 * inn[10]
            ) % 11) % 10);
        }

        return false;
    };


    return (
        <div className='wrapper'>
            <h1>Поиск компании по ИНН</h1>


            <form style={{marginBottom: '1rem'}}
                  onSubmit={handleSubmit(onSubmit)}
            >
                <input
                    name="inn_input"
                    ref={register({
                        required: true,
                        validate: innValidate
                    })}
                />

                &nbsp;
                <button type='submit'>Поиск</button>
                <div>
                    {errors.inn_input && <p>Введенный "ИНН" код не правильный</p>}
                </div>
            </form>

            {loading && <Loader/>}
            {result ? <Company  {...result} /> : ''}
            {failedSearch ? <p>Поиск по "{failedSearch.inn}" не дал результатов</p> : ''}
            {
                oldResult.length > 1 && (
                    <>
                        <p>Ранее искали :</p>
                        <OldResultList todos={oldResult}/>
                    </>
                )
            }
        </div>
    )
}

export default Main;