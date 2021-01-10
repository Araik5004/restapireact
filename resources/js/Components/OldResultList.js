import React from 'react'
import OldResultItem from './OldResultItem'

const styles = {
    ul: {
        listStyle: 'none',
        margin: 0,
        padding: 0
    }
};

function OldResultList(props) {
    return (
        <ul style={styles.ul}>
            {props.todos.map((todo, index) => {

                if (index !== 0) {
                    return (
                        <OldResultItem
                            todo={todo}
                            key={index}
                        />
                    )
                }

            })}
        </ul>
    )
}


export default OldResultList
