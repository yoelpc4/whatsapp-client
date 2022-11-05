import lowerCase from 'lodash/lowerCase';
import startCase from 'lodash/startCase';

export const formatDate = date => date ? new Date().toLocaleDateString() : null

export const titleCase = value => startCase(lowerCase(value))
