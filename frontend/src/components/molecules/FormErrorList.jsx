import ErrorAlert from '../atoms/Alerts/ErrorAlert'

const FormErrorList = ({ errors, onClose }) => {
    if (!errors) return null;

    let messages = [];

    if (typeof errors === 'string') {
        messages = [errors];
    } else if (Array.isArray(errors)) {
        messages = errors;
    } else if (typeof errors === 'object') {
        messages = Object.values(errors).flat();
    }

    if (messages.length === 0) return null;

    return (
        <ErrorAlert onClose={onClose}>
            {messages.length === 1 ? (
                messages[0]
            ) : (
                <ul style={{ margin: 0, paddingLeft: '1rem' }}>
                    {messages.map((message, index) => (
                        <li key={index}>{message}</li>
                    ))}
                </ul>
            )}
        </ErrorAlert>
    );
};

export default FormErrorList;