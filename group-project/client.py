import tkinter as tk
from tkinter import Label, Entry, Button, Toplevel, Text, Scrollbar, ttk
from tkinter.ttk import Combobox
import json
import socket

specializari = {
    'Info germana': 'IG',
    'Info romana': 'I',
    'Info engleza': 'IE',
    'Info maghiara': 'IM',
    'Mate romana': 'M',
    'Mate-info romana': 'MI',
    'Mate-info engleza': 'MIE',
    'Mate maghiara': 'MM',
    'Mate-info maghiara': 'MIM',
    'Ingineria informatiei maghiara': 'IIM',
    'Inteligenta articiala engleza': 'IA',
    'Ingineria informatiei engleza': 'II',
    'Psihologie': 'Psiho'
}


def send_data():
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)

    spec_key = spec.get()

    client_data = {
        'year': year.get(),
        'semester': semester.get(),
        'spec': specializari[spec_key],
        'acad_year': acad_year.get(),
        'group': group.get(),
        'sub_group': sub_group.get()
    }

    client_data = json.dumps(client_data).encode('utf-8')
    client_socket.sendto(client_data, ('127.0.0.1', 5555))

    server_data, server_address = client_socket.recvfrom(50000)
    server_data = server_data.decode('utf-8')

    client_data = json.loads(client_data.decode('utf-8'))

    client_socket.close()

    result_window = Toplevel(root)
    result_window.title("Result")
    result_window.geometry("1920x1080")

    server_data = json.loads(server_data)

    if len(server_data) == 0:
        text = "No timetable was found!"
        label = Label(result_window, text=text, font=("Arial", 20))
        label.pack(pady=20)
    else:
        table_headers = list(server_data[0].keys())

        timetable = []

        subgroup = '/' + client_data['sub_group']

        for course in server_data:
            if '/' in course['Formatia'] and subgroup not in course['Formatia']:
                continue
            timetable.append(course)

        tree = ttk.Treeview(result_window)
        tree["columns"] = tuple(range(1, len(table_headers) + 1))
        tree.column("#0", width=0, stretch=tk.NO)
        tree.heading("#0", text="", anchor=tk.W)
        for i in range(1, 9):
            tree.column(str(i), anchor=tk.W, width=100)
            tree.heading(str(i), text=f"{table_headers[i - 1]}", anchor=tk.W)

        for entry in timetable:
            values = tuple(entry.values())
            tree.insert("", "end", values=values)

        style = ttk.Style()
        style.configure("Treeview", rowheight=25, borderwidth=1, relief="solid")
        style.map("Treeview", background=[('selected', 'blue')], foreground=[('selected', 'white')])

        tree.pack(fill=tk.BOTH, expand=1, padx=0)


root = tk.Tk()
root.title("Data Input")
root.geometry("600x400")

Label(root, text="University Year: ", font=("Arial", 14)).grid(row=0, column=0)
year_values = ['2023', '2022', '2021', '2020']
year = Combobox(root, values=year_values, width=20, font=("Arial", 14))
year.grid(row=0, column=1)

Label(root, text="Semester: ", font=("Arial", 14)).grid(row=1, column=0)
semester_values = ['1', '2']
semester = Combobox(root, values=semester_values, width=20, font=("Arial", 14))
semester.grid(row=1, column=1)

Label(root, text="Specialization: ", font=("Arial", 14)).grid(row=2, column=0)
spec_values = list(specializari.keys())
spec = Combobox(root, values=spec_values, width=20, font=("Arial", 14))
spec.grid(row=2, column=1)

Label(root, text="Academic Year: ", font=("Arial", 14)).grid(row=3, column=0)
acad_year_values = ['1', '2', '3']
acad_year = Combobox(root, values=acad_year_values, width=20, font=("Arial", 14))
acad_year.grid(row=3, column=1)

Label(root, text="Group: ", font=("Arial", 14)).grid(row=4, column=0)
group_values = ['1', '2', '3', '4', '5', '6', '7']
group = Combobox(root, values=group_values, width=20, font=("Arial", 14))
group.grid(row=4, column=1)

Label(root, text="Semigroup: ", font=("Arial", 14)).grid(row=5, column=0)
sub_group_values = ['1', '2']
sub_group = Combobox(root, values=sub_group_values, width=20, font=("Arial", 14))
sub_group.grid(row=5, column=1)

send_button = Button(root, text="Get timetable", command=send_data, font=("Arial", 14))
send_button.grid(row=6, column=0, columnspan=2, pady=20)

root.mainloop()
