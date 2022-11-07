import lowerCase from 'lodash/lowerCase';
import startCase from 'lodash/startCase';

export const formatDateTime = value => {
    if (!value) {
        return value
    }

    const dateInstance = new Date(value)

    const date = dateInstance.toLocaleDateString()

    const time = dateInstance.toLocaleTimeString()

    return `${date} ${time}`
}

export const titleCase = value => startCase(lowerCase(value))
