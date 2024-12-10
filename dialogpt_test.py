from transformers import AutoModelForCausalLM, AutoTokenizer

# Load the tokenizer and model
tokenizer = AutoTokenizer.from_pretrained("microsoft/DialoGPT-small")
model = AutoModelForCausalLM.from_pretrained("microsoft/DialoGPT-small")

# Input message
inputs = tokenizer.encode("Hello!", return_tensors="pt")

# Generate a response
outputs = model.generate(inputs)

# Decode and print the output
print(tokenizer.decode(outputs[0]))
