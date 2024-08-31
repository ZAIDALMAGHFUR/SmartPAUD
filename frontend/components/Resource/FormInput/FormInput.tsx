import React, { ChangeEvent } from 'react';

interface FormInputProps {
    label: any;
    id: any;
    type: any;
    name: any;
    placeholder: any;
    value: any;
    readOnly: boolean;
    errorMessage?: any;
    onChange: (e: ChangeEvent<HTMLInputElement>) => void;
}

const FormInput: React.FC<FormInputProps> = ({ label, id, type, name, placeholder, value, readOnly, errorMessage, onChange }) => {
    return (
        <div>
            <label htmlFor={id}>{label} :</label>
            <input
                id={id}
                type={type}
                name={name}
                className="form-input"
                placeholder={placeholder}
                value={value}
                readOnly={readOnly}
                onChange={onChange}
            />
            {errorMessage && <div className="mt-2 text-danger">{errorMessage}</div>}
        </div>
    );
};

export default FormInput;
