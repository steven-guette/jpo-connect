import TextInput from './TextInput'

const EmailInput = ({ value, label = 'Adresse e-mail', ...props }) => (
    <TextInput
        type='email'
        placeholder='you@example.com'
        label={label}
        value={value}
        {...props}
    />
)

export default EmailInput