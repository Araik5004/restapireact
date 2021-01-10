import React from 'react'

const styles = {
    li: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        padding: '.5rem 1rem',
        border: '1px solid #ccc',
        borderRadius: '4px',
        marginBottom: '.5rem'
    },
    input: {
        marginRight: '1rem'
    }
};

function Company(props) {

    return (
        <div style={styles.li}>
      <span>
        &nbsp;
          <p>ИНН компании : {props.company_inn}</p>

        <hr
            style={{
                color: '#fff',
                backgroundColor: 'blue',
            }}
        />
        <p>КПП компании : {props.company_kpp}</p>
        <p>Название компании : {props.company_name}</p>
        <p>Адрес компании : {props.company_address}</p>
      </span>

        </div>
    )
}


export default Company
