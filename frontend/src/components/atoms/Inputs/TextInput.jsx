import { TextInput as MantineTextInput } from '@mantine/core'

const TextInput = ({ label, labelProps, placeholder, value, type = 'text', ...props }) => (
    <MantineTextInput
        label={label}
        labelProps={labelProps ?? { style: { color: '#000', fontWeight: 700 } }}
        placeholder={placeholder}
        value={value}
        type={type}
        {...props}
    />
)

export default TextInput