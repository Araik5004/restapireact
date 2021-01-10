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

function OldResultItem({ todo }) {


  return (
    <li style={styles.li}>
      <span >
        &nbsp;
        <p>ИНН компании :  {todo.company_inn}</p>

        <hr
            style={{
              color:'#fff',
              backgroundColor: 'blue',
            }}
        />
        <p>КПП компании :  {todo.company_kpp}</p>
        <p>Название компании :  {todo.company_name}</p>
        <p>Адрес компании : {todo.company_address}</p>
      </span>

    </li>
  )
}


export default OldResultItem
