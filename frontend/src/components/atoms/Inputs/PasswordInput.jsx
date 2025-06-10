import TextInput from './TextInput'

const PasswordInput = ({ value, label = 'Mot de passe', ...props }) => (
    <TextInput
        type='password'
        placeholder='••••••••'
        label={label}
        value={value}
        {...props}
    />
)

export default PasswordInput